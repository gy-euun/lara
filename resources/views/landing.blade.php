@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-4">위험성 평가 시스템에 오신 것을 환영합니다</h1>
                <p class="mb-4">이 시스템은 프로젝트의 위험성을 평가하고 관리하는 데 도움을 드립니다.</p>
                @auth
                    <a href="{{ route('projects.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        프로젝트 목록 보기
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        로그인
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection 