@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">프로젝트 관리</h1>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        프로젝트명
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        생성자
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        상태
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        생성일
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        작업
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($projects as $project)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $project->name }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($project->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $project->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $project->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($project->status === 'active')
                                    bg-green-100 text-green-800
                                @elseif($project->status === 'completed')
                                    bg-blue-100 text-blue-800
                                @else
                                    bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $project->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                보기
                            </a>
                            <form action="#" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('정말 삭제하시겠습니까?')">
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
        {{ $projects->links() }}
    </div>
</div>
@endsection 