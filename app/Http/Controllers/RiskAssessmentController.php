<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\RiskAssessment;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class RiskAssessmentController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->authorizeResource(RiskAssessment::class, 'assessment');
    }

    public function index()
    {
        $assessments = RiskAssessment::with(['industry', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        
        return view('risk-assessments.index', compact('assessments'));
    }

    public function create()
    {
        $industries = Industry::all();
        return view('risk-assessments.create', compact('industries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'project_name' => 'required|string|max:255',
            'assessment_date' => 'required|date',
            'processes' => 'required|array',
            'processes.*' => 'string',
            'equipments' => 'required|array',
            'equipments.*' => 'string',
        ]);

        $assessment = RiskAssessment::create([
            'user_id' => auth()->id(),
            'industry_id' => $validated['industry_id'],
            'project_name' => $validated['project_name'],
            'assessment_date' => $validated['assessment_date'],
            'assessment_no' => RiskAssessment::generateAssessmentNo(),
            'status' => 'draft'
        ]);

        // 공정 정보 저장
        foreach ($validated['processes'] as $process) {
            $assessment->processes()->create([
                'process_name' => $process,
                'is_custom' => true
            ]);
        }

        // 장비 정보 저장
        foreach ($validated['equipments'] as $equipment) {
            $assessment->equipments()->create([
                'equipment_name' => $equipment,
                'is_custom' => true
            ]);
        }

        if ($request->has('generate_ai_assessment')) {
            $this->generateAIAssessment($assessment);
        }

        return redirect()->route('risk-assessments.edit', $assessment)
            ->with('success', '위험성평가가 생성되었습니다.');
    }

    public function show(RiskAssessment $assessment)
    {
        $assessment->load(['industry', 'processes', 'equipments', 'items']);
        return view('risk-assessments.show', compact('assessment'));
    }

    public function edit(RiskAssessment $assessment)
    {
        $assessment->load(['processes', 'equipments', 'items']);
        return view('risk-assessments.edit', compact('assessment'));
    }

    public function update(Request $request, RiskAssessment $assessment)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'nullable|exists:risk_assessment_items,id',
            'items.*.detail_process' => 'required|string',
            'items.*.hazard_type' => 'required|string',
            'items.*.hazard_cause' => 'required|string',
            'items.*.risk_factor' => 'required|string',
            'items.*.probability' => 'required|integer|min:1|max:5',
            'items.*.severity' => 'required|integer|min:1|max:5',
            'items.*.reduction_measures' => 'required|string',
            'items.*.manager' => 'required|string',
        ]);

        foreach ($validated['items'] as $item) {
            $riskScore = $item['probability'] * $item['severity'];
            
            if (isset($item['id'])) {
                $assessment->items()->where('id', $item['id'])->update([
                    ...$item,
                    'risk_score' => $riskScore
                ]);
            } else {
                $assessment->items()->create([
                    ...$item,
                    'risk_score' => $riskScore,
                    'risk_assessment_process_id' => $assessment->processes->first()->id
                ]);
            }
        }

        return redirect()->route('risk-assessments.edit', $assessment)
            ->with('success', '위험성평가가 수정되었습니다.');
    }

    public function destroy(RiskAssessment $assessment)
    {
        $assessment->delete();
        return redirect()->route('risk-assessments.index')
            ->with('success', '위험성평가가 삭제되었습니다.');
    }

    public function generatePdf(RiskAssessment $assessment)
    {
        $this->authorize('view', $assessment);
        // PDF 생성 로직 구현
        return response()->json(['message' => 'PDF 생성 기능은 아직 구현되지 않았습니다.']);
    }

    protected function generateAIAssessment(RiskAssessment $assessment)
    {
        $processes = $assessment->processes->pluck('process_name')->join(', ');
        $equipments = $assessment->equipments->pluck('equipment_name')->join(', ');

        $prompt = "다음 공정과 장비에 대한 위험성평가 항목을 생성해주세요.\n\n";
        $prompt .= "공정: {$processes}\n";
        $prompt .= "장비: {$equipments}\n\n";
        $prompt .= "다음 형식으로 JSON 배열을 반환해주세요:\n";
        $prompt .= '[{"detail_process": "세부작업명", "hazard_type": "위험분류", "hazard_cause": "위험원인", "risk_factor": "유해위험요인", "probability": 1-5, "severity": 1-5, "reduction_measures": "감소대책", "manager": "담당자"}]';

        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => '당신은 산업안전 전문가입니다. 위험성평가 항목을 생성할 때는 실제 현장에서 발생할 수 있는 구체적인 위험 요소를 고려하여 현실적인 평가 항목을 생성해주세요.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000
            ]);

            $items = json_decode($result->choices[0]->message->content, true);
            
            if (!is_array($items)) {
                throw new \Exception('AI가 올바른 형식의 응답을 생성하지 못했습니다.');
            }

            foreach ($items as $item) {
                if (!isset($item['detail_process'], $item['hazard_type'], $item['hazard_cause'], 
                         $item['risk_factor'], $item['probability'], $item['severity'], 
                         $item['reduction_measures'], $item['manager'])) {
                    continue;
                }

                $assessment->items()->create([
                    ...$item,
                    'risk_score' => $item['probability'] * $item['severity'],
                    'risk_assessment_process_id' => $assessment->processes->first()->id,
                    'is_ai_generated' => true
                ]);
            }
        } catch (\Exception $e) {
            // API 오류 발생 시 사용자에게 알림
            session()->flash('error', 'AI 생성 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }
}
