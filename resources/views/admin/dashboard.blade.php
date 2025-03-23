@extends('layouts.admin')

@section('content')
<div x-data="{ showStats: true }" x-cloak>
    <h1 class="text-2xl font-bold">관리자 대시보드</h1>

    <!-- 통계 카드 -->
    <div x-show="showStats" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">사용자 통계</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_users'] }}</p>
            <p class="text-gray-600">전체 사용자 수</p>
            
            <div class="mt-4">
                <h3 class="text-sm font-medium text-gray-500 mb-2">최근 가입한 사용자</h3>
                <ul class="space-y-2">
                    @foreach($stats['recent_users'] as $user)
                        <li class="text-sm">
                            {{ $user->name }} ({{ $user->email }})
                            <span class="text-gray-400 text-xs">{{ $user->created_at->format('Y-m-d') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">프로젝트 통계</h2>
            <p class="text-3xl font-bold text-green-600">{{ $stats['total_projects'] }}</p>
            <p class="text-gray-600">전체 프로젝트 수</p>
            
            <div class="mt-4">
                <h3 class="text-sm font-medium text-gray-500 mb-2">최근 생성된 프로젝트</h3>
                <ul class="space-y-2">
                    @foreach($stats['recent_projects'] as $project)
                        <li class="text-sm">
                            {{ $project->name }}
                            <span class="text-gray-400 text-xs">{{ $project->created_at->format('Y-m-d') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- 시스템 상태 -->
    <div x-show="showStats" class="bg-white rounded-lg shadow p-6 mt-6">
        <h2 class="text-lg font-semibold mb-4">시스템 상태</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <p class="text-sm text-gray-500">PHP 버전</p>
                <p class="font-medium">{{ phpversion() }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Laravel 버전</p>
                <p class="font-medium">{{ app()->version() }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">환경</p>
                <p class="font-medium">{{ config('app.env') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">디버그 모드</p>
                <p class="font-medium">{{ config('app.debug') ? '활성화' : '비활성화' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush 