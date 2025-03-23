<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $documents = $project->documents()->latest()->paginate(10);
        
        return view('documents.index', [
            'project' => $project,
            'documents' => $documents,
            'showSidebarB' => true
        ]);
    }

    public function create(Project $project)
    {
        $this->authorize('update', $project);
        return view('documents.create', [
            'project' => $project,
            'showSidebarB' => true
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 최대 10MB
        ]);

        $path = $request->file('file')->store('documents');

        $project->documents()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $path,
        ]);

        return redirect()->route('projects.documents.index', $project)
            ->with('success', '문서가 업로드되었습니다.');
    }

    public function show(Project $project, Document $document)
    {
        $this->authorize('view', $project);
        return view('documents.show', [
            'project' => $project,
            'document' => $document,
            'showSidebarB' => true
        ]);
    }

    public function edit(Project $project, Document $document)
    {
        $this->authorize('update', $project);
        return view('documents.edit', [
            'project' => $project,
            'document' => $document,
            'showSidebarB' => true
        ]);
    }

    public function update(Request $request, Project $project, Document $document)
    {
        $this->authorize('update', $project);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 최대 10MB
        ]);

        if ($request->hasFile('file')) {
            // 기존 파일 삭제
            Storage::delete($document->file_path);
            // 새 파일 저장
            $path = $request->file('file')->store('documents');
            $validated['file_path'] = $path;
        }

        $document->update($validated);

        return redirect()->route('projects.documents.show', [$project, $document])
            ->with('success', '문서가 수정되었습니다.');
    }

    public function destroy(Project $project, Document $document)
    {
        $this->authorize('delete', $project);
        
        // 파일 삭제
        Storage::delete($document->file_path);
        $document->delete();

        return redirect()->route('projects.documents.index', $project)
            ->with('success', '문서가 삭제되었습니다.');
    }
} 