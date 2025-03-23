<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\RiskAssessment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where('user_id', auth()->id())->latest()->get();
        return view('projects.index', [
            'projects' => $projects,
            'showSidebarB' => false
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create', ['showSidebarB' => false]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,completed,on_hold',
        ]);

        $project = auth()->user()->projects()->create($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', '프로젝트가 생성되었습니다.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.show', [
            'project' => $project,
            'showSidebarB' => true
        ]);
    }

    /**
     * 프로젝트 대시보드를 표시합니다.
     */
    public function dashboard(Project $project)
    {
        $this->authorize('view', $project);
        
        // 프로젝트 통계 데이터
        $stats = [
            'risk_assessments_count' => RiskAssessment::where('project_name', $project->name)
                ->where('user_id', $project->user_id)
                ->count(),
            'workers_count' => $project->workers()->count(),
            'documents_count' => $project->documents()->count(),
        ];

        return view('projects.dashboard', [
            'project' => $project,
            'stats' => $stats,
            'showSidebarB' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', [
            'project' => $project,
            'showSidebarB' => false
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,completed,on_hold',
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', '프로젝트가 수정되었습니다.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', '프로젝트가 삭제되었습니다.');
    }
}
