<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'likes', 'comments'])
            ->withCount(['likes', 'comments']);

        // 카테고리별 필터링
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // 인기글 필터링
        if ($request->filter === 'popular') {
            $query->popular();
        }

        // 프로젝트 필터링
        if ($request->filter === 'projects') {
            $query->where('category', 'project');
        }

        // 노하우 필터링
        if ($request->filter === 'knowhow') {
            $query->where('category', 'knowhow');
        }

        // Q&A 필터링
        if ($request->filter === 'qna') {
            $query->where('category', 'qna');
        }

        $posts = $query->latest()->paginate(15);

        return view('community.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('community.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required|in:general,project,knowhow,qna',
            'is_notice' => 'boolean',
            'is_private' => 'boolean',
            'tags' => 'nullable|string'
        ]);

        $post = auth()->user()->posts()->create($validated);

        return redirect()->route('community.posts.show', $post)
            ->with('success', '게시글이 작성되었습니다.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes']);
        $post->incrementViewCount(auth()->user(), request()->ip());
        
        return view('community.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('community.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required|in:general,project,knowhow,qna',
            'is_notice' => 'boolean',
            'is_private' => 'boolean',
            'tags' => 'nullable|string'
        ]);

        $post->update($validated);

        return redirect()->route('community.posts.show', $post)
            ->with('success', '게시글이 수정되었습니다.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('community.posts.index')
            ->with('success', '게시글이 삭제되었습니다.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/uploads/posts', $filename);
            
            return response()->json([
                'location' => asset('storage/uploads/posts/' . $filename)
            ]);
        }
        
        return response()->json([
            'error' => '파일이 업로드되지 않았습니다.'
        ], 400);
    }

    public function toggleLike(Post $post)
    {
        $liked = $post->toggleLike(auth()->user());
        return response()->json([
            'liked' => $liked,
            'likeCount' => $post->like_count
        ]);
    }
}
