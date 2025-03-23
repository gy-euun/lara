@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">{{ $project->name }}</h1>
                        <span class="px-2 py-1 text-sm rounded
                            @if($project->status === 'active')
                                bg-green-100 text-green-800
                            @elseif($project->status === 'completed')
                                bg-blue-100 text-blue-800
                            @else
                                bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('projects.edit', $project) }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            수정
                        </a>
                        <form action="{{ route('projects.destroy', $project) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('정말 삭제하시겠습니까?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                삭제
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-semibold mb-4">프로젝트 설명</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $project->description }}</p>
                </div>

                <div class="border-t pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">위험성 평가</h2>
                        <a href="{{ route('projects.risk-assessments.create', $project) }}" 
                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            새 위험성 평가
                        </a>
                    </div>

                    @if($project->riskAssessments->isEmpty())
                        <p class="text-gray-500 text-center py-4">등록된 위험성 평가가 없습니다.</p>
                    @else
                        <div class="grid gap-4">
                            @foreach($project->riskAssessments as $assessment)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-semibold mb-1">
                                                <a href="{{ route('projects.risk-assessments.show', [$project, $assessment]) }}" 
                                                   class="text-blue-600 hover:text-blue-800">
                                                    {{ $assessment->title }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-600">{{ Str::limit($assessment->description, 100) }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-sm rounded
                                            @if($assessment->risk_level === 'high')
                                                bg-red-100 text-red-800
                                            @elseif($assessment->risk_level === 'medium')
                                                bg-yellow-100 text-yellow-800
                                            @else
                                                bg-green-100 text-green-800
                                            @endif">
                                            {{ ucfirst($assessment->risk_level) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mt-6">
                    <a href="{{ route('projects.index') }}" class="text-blue-600 hover:text-blue-800">
                        ← 프로젝트 목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 