@if($posts->count() > 0)
    <div class="bg-white rounded-lg shadow">
        <div class="divide-y">
            @foreach($posts as $post)
                <div class="p-6 flex items-center space-x-4">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2">
                            @if($post->is_notice)
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">공지</span>
                            @endif
                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">{{ $post->category }}</span>
                        </div>
                        <a href="{{ route('community.posts.show', $post) }}" class="block mt-2">
                            <h3 class="text-lg font-semibold hover:text-blue-600">{{ $post->title }}</h3>
                        </a>
                        <div class="mt-2 text-sm text-gray-600">
                            <span>{{ $post->user->name }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                            <span class="mx-2">•</span>
                            <span>조회 {{ $post->view_count }}</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-gray-600">좋아요</div>
                        <div class="text-lg font-semibold">{{ $post->like_count }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-gray-600">댓글</div>
                        <div class="text-lg font-semibold">{{ $post->comments_count }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-6">
        {{ $posts->links() }}
    </div>
@else
    <div class="bg-white rounded-lg shadow p-6 text-center text-gray-600">
        게시글이 없습니다.
    </div>
@endif 