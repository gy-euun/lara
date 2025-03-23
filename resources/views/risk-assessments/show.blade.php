@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">위험성 평가 상세</h1>
                    <div class="space-x-4">
                        <a href="{{ route('projects.risk-assessments.edit', ['project' => $project->id, 'risk_assessment' => $riskAssessment->id]) }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            수정
                        </a>
                        <form action="{{ route('projects.risk-assessments.destroy', ['project' => $project->id, 'risk_assessment' => $riskAssessment->id]) }}" 
                              method="POST" 
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                    onclick="return confirm('정말 삭제하시겠습니까?')">
                                삭제
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-2">기본 정보</h2>
                        <dl class="grid grid-cols-2 gap-4">
                            <dt class="text-gray-600">제목</dt>
                            <dd>{{ $riskAssessment->title }}</dd>
                            
                            <dt class="text-gray-600">위험 수준</dt>
                            <dd>
                                <span class="px-2 py-1 rounded text-sm
                                    @if($riskAssessment->risk_level === 'high')
                                        bg-red-100 text-red-800
                                    @elseif($riskAssessment->risk_level === 'medium')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($riskAssessment->risk_level) }}
                                </span>
                            </dd>
                            
                            <dt class="text-gray-600">생성일</dt>
                            <dd>{{ $riskAssessment->created_at->format('Y-m-d H:i') }}</dd>
                            
                            <dt class="text-gray-600">수정일</dt>
                            <dd>{{ $riskAssessment->updated_at->format('Y-m-d H:i') }}</dd>
                        </dl>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-2">상세 설명</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($riskAssessment->description)) !!}
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('projects.show', $project->id) }}" 
                       class="text-blue-600 hover:text-blue-800">
                        ← 프로젝트로 돌아가기
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 