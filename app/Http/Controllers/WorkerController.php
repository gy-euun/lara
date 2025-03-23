<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WorkerController extends Controller
{
    use AuthorizesRequests;

    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $workers = $project->workers()->latest()->paginate(10);
        
        return view('workers.index', [
            'project' => $project,
            'workers' => $workers,
            'showSidebarB' => true
        ]);
    }

    public function create(Project $project)
    {
        $this->authorize('update', $project);
        return view('workers.create', [
            'project' => $project,
            'showSidebarB' => true
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        $project->workers()->create($validated);

        return redirect()->route('projects.workers.index', $project)
            ->with('success', '근로자가 등록되었습니다.');
    }

    public function show(Project $project, Worker $worker)
    {
        $this->authorize('view', $project);
        return view('workers.show', [
            'project' => $project,
            'worker' => $worker,
            'showSidebarB' => true
        ]);
    }

    public function edit(Project $project, Worker $worker)
    {
        $this->authorize('update', $project);
        return view('workers.edit', [
            'project' => $project,
            'worker' => $worker,
            'showSidebarB' => true
        ]);
    }

    public function update(Request $request, Project $project, Worker $worker)
    {
        $this->authorize('update', $project);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        $worker->update($validated);

        return redirect()->route('projects.workers.show', [$project, $worker])
            ->with('success', '근로자 정보가 수정되었습니다.');
    }

    public function destroy(Project $project, Worker $worker)
    {
        $this->authorize('delete', $project);
        $worker->delete();

        return redirect()->route('projects.workers.index', $project)
            ->with('success', '근로자가 삭제되었습니다.');
    }
} 