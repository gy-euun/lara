@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">
                근로자 관리
            </h1>
            <a href="{{ route('projects.workers.create', $project) }}" 
               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                근로자 등록
            </a>
        </div>

        <!-- 근로자 목록 -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @if($workers->isEmpty())
                    <p class="text-gray-500 text-center py-4">등록된 근로자가 없습니다.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        이름
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        직책
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        등록일
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        작업
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($workers as $worker)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $worker->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                {{ $worker->position }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $worker->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('projects.workers.show', [$project, $worker]) }}" 
                                               class="text-blue-600 hover:text-blue-900 mr-3">
                                                상세보기
                                            </a>
                                            <a href="{{ route('projects.workers.edit', [$project, $worker]) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                수정
                                            </a>
                                            <form action="{{ route('projects.workers.destroy', [$project, $worker]) }}" 
                                                  method="POST" 
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('정말 삭제하시겠습니까?')">
                                                    삭제
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $workers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 