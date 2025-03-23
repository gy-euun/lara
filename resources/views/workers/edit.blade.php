@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                근로자 정보 수정
            </h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('projects.workers.update', [$project, $worker]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">이름</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $worker->name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="position" class="block text-sm font-medium text-gray-700">직책</label>
                        <select name="position" 
                                id="position" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            <option value="">직책 선택</option>
                            <option value="현장소장" {{ old('position', $worker->position) == '현장소장' ? 'selected' : '' }}>현장소장</option>
                            <option value="안전관리자" {{ old('position', $worker->position) == '안전관리자' ? 'selected' : '' }}>안전관리자</option>
                            <option value="근로자" {{ old('position', $worker->position) == '근로자' ? 'selected' : '' }}>근로자</option>
                        </select>
                        @error('position')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('projects.workers.show', [$project, $worker]) }}" 
                           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            취소
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            수정
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 