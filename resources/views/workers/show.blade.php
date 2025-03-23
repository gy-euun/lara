@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">
                근로자 상세 정보
            </h1>
            <div class="space-x-3">
                <a href="{{ route('projects.workers.edit', [$project, $worker]) }}" 
                   class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">
                    수정
                </a>
                <form action="{{ route('projects.workers.destroy', [$project, $worker]) }}" 
                      method="POST" 
                      class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                            onclick="return confirm('정말 삭제하시겠습니까?')">
                        삭제
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">이름</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $worker->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">직책</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $worker->position }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">등록일</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $worker->created_at->format('Y-m-d') }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">최종 수정일</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $worker->updated_at->format('Y-m-d') }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <a href="{{ route('projects.workers.index', $project) }}" 
                       class="text-blue-600 hover:text-blue-900">
                        ← 근로자 목록으로 돌아가기
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 