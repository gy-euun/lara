@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-8">위험성평가 작성</h1>

        <form action="{{ route('risk-assessments.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- 1단계: 기본 정보 -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">1. 기본 정보</h2>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="project_name" class="block text-sm font-medium text-gray-700">프로젝트명</label>
                        <input type="text" name="project_name" id="project_name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="assessment_date" class="block text-sm font-medium text-gray-700">평가일</label>
                        <input type="date" name="assessment_date" id="assessment_date" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="industry_id" class="block text-sm font-medium text-gray-700">업종 선택</label>
                        <select name="industry_id" id="industry_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">업종을 선택하세요</option>
                            @foreach($industries as $industry)
                                <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- 2단계: 공정 정보 -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">2. 공정 정보</h2>
                <div id="processes" class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <input type="text" name="processes[]" required placeholder="공정명을 입력하세요"
                               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="button" onclick="addProcess()"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            추가
                        </button>
                    </div>
                </div>
            </div>

            <!-- 3단계: 장비 정보 -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">3. 장비 정보</h2>
                <div id="equipments" class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <input type="text" name="equipments[]" required placeholder="장비명을 입력하세요"
                               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="button" onclick="addEquipment()"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            추가
                        </button>
                    </div>
                </div>
            </div>

            <!-- AI 생성 옵션 -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="generate_ai_assessment" id="generate_ai_assessment"
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <label for="generate_ai_assessment" class="text-sm font-medium text-gray-700">
                        AI로 위험성평가 항목 자동 생성
                    </label>
                </div>
            </div>

            <!-- 제출 버튼 -->
            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600">
                    위험성평가 생성
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function addProcess() {
    const container = document.getElementById('processes');
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-4';
    div.innerHTML = `
        <input type="text" name="processes[]" required placeholder="공정명을 입력하세요"
               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <button type="button" onclick="this.parentElement.remove()"
                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
            삭제
        </button>
    `;
    container.appendChild(div);
}

function addEquipment() {
    const container = document.getElementById('equipments');
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-4';
    div.innerHTML = `
        <input type="text" name="equipments[]" required placeholder="장비명을 입력하세요"
               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <button type="button" onclick="this.parentElement.remove()"
                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
            삭제
        </button>
    `;
    container.appendChild(div);
}
</script>
@endpush
@endsection 