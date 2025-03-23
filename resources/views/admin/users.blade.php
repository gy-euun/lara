@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">사용자 관리</h1>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        이름
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        이메일
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        가입일
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        권한
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        작업
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_admin ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $user->is_admin ? '관리자' : '일반 사용자' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="#" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    {{ $user->is_admin ? '관리자 해제' : '관리자 지정' }}
                                </button>
                            </form>
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
        {{ $users->links() }}
    </div>
</div>
@endsection 