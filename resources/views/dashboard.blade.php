@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-4">대시보드</h1>
                <p class="mb-4">환영합니다, {{ Auth::user()->name }}님!</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-blue-100 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-2">프로젝트</h2>
                        <p class="text-gray-600">현재 진행 중인 프로젝트를 관리하세요.</p>
                        <a href="{{ route('projects.index') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800">프로젝트 목록 →</a>
                    </div>
                    
                    <div class="bg-green-100 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-2">위험성 평가</h2>
                        <p class="text-gray-600">프로젝트의 위험성을 평가하고 관리하세요.</p>
                        <a href="{{ route('projects.index') }}" class="mt-2 inline-block text-green-600 hover:text-green-800">위험성 평가 시작 →</a>
                    </div>
                    
                    <div class="bg-purple-100 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-2">프로필</h2>
                        <p class="text-gray-600">계정 정보를 관리하세요.</p>
                        <a href="{{ route('profile.edit') }}" class="mt-2 inline-block text-purple-600 hover:text-purple-800">프로필 설정 →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
