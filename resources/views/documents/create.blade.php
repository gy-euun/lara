@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                문서 등록
            </h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('projects.documents.store', $project) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">제목</label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">설명</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700">파일</label>
                        <input type="file" 
                               name="file" 
                               id="file" 
                               class="mt-1 block w-full"
                               required>
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">최대 파일 크기: 10MB</p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('projects.documents.index', $project) }}" 
                           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            취소
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            등록
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 