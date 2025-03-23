@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">
                문서 상세 정보
            </h1>
            <div class="space-x-3">
                <a href="{{ route('projects.documents.edit', [$project, $document]) }}" 
                   class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">
                    수정
                </a>
                <form action="{{ route('projects.documents.destroy', [$project, $document]) }}" 
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
                        <dt class="text-sm font-medium text-gray-500">제목</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $document->title }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">파일명</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $document->original_filename }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">설명</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $document->description }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">등록일</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $document->created_at->format('Y-m-d') }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">최종 수정일</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $document->updated_at->format('Y-m-d') }}</dd>
                    </div>
                </dl>

                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('projects.documents.index', $project) }}" 
                       class="text-blue-600 hover:text-blue-900">
                        ← 문서 목록으로 돌아가기
                    </a>
                    <a href="{{ route('projects.documents.download', [$project, $document]) }}" 
                       class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        파일 다운로드
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 