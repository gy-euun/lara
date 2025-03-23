<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\RiskAssessment;
use Illuminate\Http\Request;

class RiskAssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $riskAssessments = $project->riskAssessments()->latest()->get();
        
        return view('risk_assessments.index', [
            'project' => $project,
            'riskAssessments' => $riskAssessments,
            'showSidebarB' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $this->authorize('update', $project);
        return view('risk_assessments.create', [
            'project' => $project,
            'showSidebarB' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'risk_level' => 'required|in:low,medium,high',
        ]);

        $project->riskAssessments()->create($validated);

        return redirect()->route('risk.index', $project)
            ->with('success', '위험성 평가가 생성되었습니다.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, RiskAssessment $riskAssessment)
    {
        $this->authorize('view', $project);
        return view('risk_assessments.show', [
            'project' => $project,
            'riskAssessment' => $riskAssessment,
            'showSidebarB' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, RiskAssessment $riskAssessment)
    {
        $this->authorize('update', $project);
        return view('risk_assessments.edit', [
            'project' => $project,
            'riskAssessment' => $riskAssessment,
            'showSidebarB' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, RiskAssessment $riskAssessment)
    {
        $this->authorize('update', $project);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'risk_level' => 'required|in:low,medium,high',
        ]);

        $riskAssessment->update($validated);

        return redirect()->route('risk.show', [$project, $riskAssessment])
            ->with('success', '위험성 평가가 업데이트되었습니다.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, RiskAssessment $riskAssessment)
    {
        $this->authorize('delete', $project);
        $riskAssessment->delete();

        return redirect()->route('risk.index', $project)
            ->with('success', '위험성 평가가 삭제되었습니다.');
    }
}
