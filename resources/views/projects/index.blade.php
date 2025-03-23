@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">📁 프로젝트 목록</h1>
                    <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        새 프로젝트
                    </a>
                </div>

                @if($projects->isEmpty())
                    <p class="text-gray-500 text-center py-4">등록된 프로젝트가 없습니다.</p>
                @else
                    <div class="grid gap-4">
                        @foreach($projects as $project)
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h2 class="text-xl font-semibold mb-2">
                                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-800">
                                                {{ $project->name }}
                                            </a>
                                        </h2>
                                        <p class="text-gray-600">{{ $project->description }}</p>
                                    </div>
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
                                <div class="mt-4 flex justify-end space-x-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('projects.dashboard', $project) }}" 
                                           class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            상세보기
                                        </a>
                                        <a href="{{ route('projects.edit', $project) }}" 
                                           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                            수정
                                        </a>
                                    </div>
                                    <form action="{{ route('projects.destroy', $project) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            삭제
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 