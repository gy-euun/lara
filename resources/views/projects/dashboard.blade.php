@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- 프로젝트 헤더 -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $project->name }} - 대시보드
                </h1>
                <p class="mt-1 text-sm text-gray-600">
                    {{ $project->description }}
                </p>
            </div>

            <!-- 프로젝트 통계 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900">
                        <h3 class="text-lg font-semibold mb-2">🧯 위험성 평가</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['risk_assessments_count'] }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900">
                        <h3 class="text-lg font-semibold mb-2">👷 근로자</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['workers_count'] }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900">
                        <h3 class="text-lg font-semibold mb-2">📂 문서</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['documents_count'] }}</p>
                    </div>
                </div>
            </div>

            <!-- 최근 활동 -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">최근 활동</h3>
                    
                    <!-- 위험성 평가 -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">최근 위험성 평가</h4>
                        @forelse($project->riskAssessments()->latest()->take(3)->get() as $assessment)
                            <div class="flex items-center justify-between py-2 border-b">
                                <div>
                                    <p class="font-medium">{{ $assessment->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $assessment->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                                <a href="{{ route('projects.risk-assessments.show', [$project, $assessment]) }}" class="text-blue-600 hover:text-blue-800">
                                    자세히 보기 →
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500">등록된 위험성 평가가 없습니다.</p>
                        @endforelse
                    </div>

                    <!-- 근로자 -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">최근 등록된 근로자</h4>
                        @forelse($project->workers()->latest()->take(3)->get() as $worker)
                            <div class="flex items-center justify-between py-2 border-b">
                                <div>
                                    <p class="font-medium">{{ $worker->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $worker->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                                <a href="{{ route('projects.workers.show', [$project, $worker]) }}" class="text-blue-600 hover:text-blue-800">
                                    자세히 보기 →
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500">등록된 근로자가 없습니다.</p>
                        @endforelse
                    </div>

                    <!-- 문서 -->
                    <div>
                        <h4 class="font-medium mb-2">최근 업로드된 문서</h4>
                        @forelse($project->documents()->latest()->take(3)->get() as $document)
                            <div class="flex items-center justify-between py-2 border-b">
                                <div>
                                    <p class="font-medium">{{ $document->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $document->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                                <a href="{{ route('projects.documents.show', [$project, $document]) }}" class="text-blue-600 hover:text-blue-800">
                                    자세히 보기 →
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500">업로드된 문서가 없습니다.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 