@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-6">새 프로젝트</h1>

                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">프로젝트명</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">설명</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">상태</label>
                        <select name="status" 
                                id="status" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>진행중</option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>완료</option>
                            <option value="on_hold" {{ old('status') === 'on_hold' ? 'selected' : '' }}>보류</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('projects.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            취소
                        </a>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            저장
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 