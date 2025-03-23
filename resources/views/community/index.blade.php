@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap -mx-4">
        <!-- 사이드바 -->
        <div class="w-full md:w-1/4 px-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">커뮤니티 정보</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600">전체 회원</p>
                        <p class="text-2xl font-bold">{{ \App\Models\User::count() }}명</p>
                    </div>
                    <div>
                        <p class="text-gray-600">전체 게시글</p>
                        <p class="text-2xl font-bold">{{ \App\Models\Post::count() }}개</p>
                    </div>
                    <div>
                        <p class="text-gray-600">오늘 방문자</p>
                        <p class="text-2xl font-bold">{{ \App\Models\PostView::whereDate('viewed_at', today())->count() }}명</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 메인 컨텐츠 -->
        <div class="w-full md:w-3/4 px-4">
            <!-- 탭 메뉴 -->
            <div class="bg-white rounded-lg shadow mb-8">
                <nav class="flex">
                    <a href="{{ route('community.posts.index') }}" 
                       class="px-6 py-4 text-gray-600 hover:text-gray-900 {{ request()->routeIs('community.posts.index') && !request()->filter ? 'border-b-2 border-blue-500' : '' }}">
                        전체글
                    </a>
                    <a href="{{ route('community.posts.filter', 'popular') }}"
                       class="px-6 py-4 text-gray-600 hover:text-gray-900 {{ request()->filter === 'popular' ? 'border-b-2 border-blue-500' : '' }}">
                        인기글
                    </a>
                    <a href="{{ route('community.posts.filter', 'projects') }}"
                       class="px-6 py-4 text-gray-600 hover:text-gray-900 {{ request()->filter === 'projects' ? 'border-b-2 border-blue-500' : '' }}">
                        프로젝트
                    </a>
                    <a href="{{ route('community.posts.filter', 'knowhow') }}"
                       class="px-6 py-4 text-gray-600 hover:text-gray-900 {{ request()->filter === 'knowhow' ? 'border-b-2 border-blue-500' : '' }}">
                        노하우
                    </a>
                    <a href="{{ route('community.posts.filter', 'qna') }}"
                       class="px-6 py-4 text-gray-600 hover:text-gray-900 {{ request()->filter === 'qna' ? 'border-b-2 border-blue-500' : '' }}">
                        Q&A
                    </a>
                </nav>
            </div>

            <!-- 게시글 목록 -->
            @include('community.posts.list')

            <!-- 글쓰기 버튼 -->
            <div class="mt-6 text-right">
                <a href="{{ route('community.posts.create') }}" 
                   class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                    글쓰기
                </a>
            </div>
        </div>
    </div>
</div>
@endsection