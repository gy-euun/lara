@extends('layouts.app')

@section('content')
<div class="flex">
    @include('layouts.sidebar_b')
    
    <div class="flex-1 p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">새 위험성 평가</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('projects.risk-assessments.store', $project->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">제목</label>
                    <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">설명</label>
                    <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>

                <div class="mb-4">
                    <label for="risk_level" class="block text-gray-700 text-sm font-bold mb-2">위험 수준</label>
                    <select name="risk_level" id="risk_level" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="low">낮음</option>
                        <option value="medium">중간</option>
                        <option value="high">높음</option>
                    </select>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        저장
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 