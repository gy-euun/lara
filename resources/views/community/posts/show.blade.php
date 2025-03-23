@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">📝 게시글 보기</h1>
            <a href="{{ route('community.posts.index') }}" 
               class="text-gray-600 hover:text-gray-900">
                목록으로 돌아가기
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b">
                <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                <div class="mt-2 text-sm text-gray-500 flex justify-between">
                    <div>
                        작성자: {{ $post->user->name }} | 
                        작성일: {{ $post->created_at->format('Y-m-d H:i') }}
                    </div>
                    @if(auth()->id() === $post->user_id)
                        <div class="space-x-2">
                            <a href="{{ route('community.posts.edit', $post) }}" 
                               class="text-indigo-600 hover:text-indigo-900">수정</a>
                            <form action="{{ route('community.posts.destroy', $post) }}" 
                                  method="POST" 
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('정말 삭제하시겠습니까?')">
                                    삭제
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            <div class="px-4 py-5 sm:px-6 whitespace-pre-wrap">
                {{ $post->content }}
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium">💬 댓글</h3>
                
                <form action="{{ route('community.posts.comments.store', $post) }}" 
                      method="POST" 
                      class="mt-4">
                    @csrf
                    <div>
                        <textarea name="content" 
                                  rows="3" 
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="댓글을 작성해주세요."
                                  required></textarea>
                    </div>
                    <div class="mt-2 flex justify-end">
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            댓글 작성
                        </button>
                    </div>
                </form>

                <div class="mt-6 space-y-4">
                    @forelse($post->comments as $comment)
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium">{{ $comment->user->name }}</p>
                                    <p class="mt-1">{{ $comment->content }}</p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $comment->created_at->format('Y-m-d H:i') }}
                                    </p>
                                </div>
                                @if(auth()->id() === $comment->user_id)
                                    <form action="{{ route('community.posts.comments.destroy', [$post, $comment]) }}" 
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('댓글을 삭제하시겠습니까?')">
                                            삭제
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">
                            아직 댓글이 없습니다.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection 