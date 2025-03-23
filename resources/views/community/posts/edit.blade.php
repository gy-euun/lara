@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <h1 class="text-2xl font-bold">✏️ 게시글 수정</h1>
        </div>

        <form action="{{ route('community.posts.update', $post) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">제목</label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       value="{{ old('title', $post->title) }}"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">내용</label>
                <textarea name="content" 
                          id="content" 
                          rows="10" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          required>{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('community.posts.show', $post) }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                    취소
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    수정하기
                </button>
            </div>
        </form>
    </div>
@endsection 