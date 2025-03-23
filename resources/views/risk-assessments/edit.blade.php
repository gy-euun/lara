@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">위험성평가 수정</h1>
            <div class="flex space-x-4">
                <button onclick="generatePDF()"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    PDF 출력
                </button>
                <button onclick="saveAssessment()"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    저장
                </button>
            </div>
        </div>

        <!-- 기본 정보 -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4">기본 정보</h2>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">프로젝트명</p>
                    <p class="font-medium">{{ $assessment->project_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">평가번호</p>
                    <p class="font-medium">{{ $assessment->assessment_no }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">업종</p>
                    <p class="font-medium">{{ $assessment->industry->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">평가일</p>
                    <p class="font-medium">{{ $assessment->assessment_date->format('Y-m-d') }}</p>
                </div>
            </div>
        </div>

        <!-- 공정 및 장비 정보 -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">공정 정보</h2>
                <ul class="list-disc list-inside space-y-2">
                    @foreach($assessment->processes as $process)
                        <li>{{ $process->process_name }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">장비 정보</h2>
                <ul class="list-disc list-inside space-y-2">
                    @foreach($assessment->equipments as $equipment)
                        <li>{{ $equipment->equipment_name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- 위험성평가 항목 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">위험성평가 항목</h2>
                <button onclick="addAssessmentItem()"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    항목 추가
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="assessment-items">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">세부작업</th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">위험분류</th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">위험원인</th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">유해위험요인</th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">가능성</th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">중대성</th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">위험성</th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">감소대책</th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">담당자</th>
                            <th class="px-4 py-3 bg-gray-50"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($assessment->items as $item)
                            <tr data-id="{{ $item->id }}">
                                <td class="px-4 py-3">
                                    <input type="text" name="items[{{ $item->id }}][detail_process]" value="{{ $item->detail_process }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="items[{{ $item->id }}][hazard_type]" value="{{ $item->hazard_type }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="items[{{ $item->id }}][hazard_cause]" value="{{ $item->hazard_cause }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="items[{{ $item->id }}][risk_factor]" value="{{ $item->risk_factor }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </td>
                                <td class="px-4 py-3">
                                    <select name="items[{{ $item->id }}][probability]" onchange="updateRiskScore(this.closest('tr'))"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ $item->probability == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <select name="items[{{ $item->id }}][severity]" onchange="updateRiskScore(this.closest('tr'))"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ $item->severity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="risk-score px-2 py-1 rounded text-sm font-medium"
                                          data-score="{{ $item->risk_score }}">
                                        {{ $item->risk_score }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="items[{{ $item->id }}][reduction_measures]" value="{{ $item->reduction_measures }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="items[{{ $item->id }}][manager]" value="{{ $item->manager }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </td>
                                <td class="px-4 py-3">
                                    <button type="button" onclick="this.closest('tr').remove()"
                                            class="text-red-600 hover:text-red-900">삭제</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function addAssessmentItem() {
    const tbody = document.querySelector('#assessment-items tbody');
    const newRow = document.createElement('tr');
    const timestamp = Date.now();
    
    newRow.innerHTML = `
        <td class="px-4 py-3">
            <input type="text" name="items[new_${timestamp}][detail_process]" required
                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </td>
        <td class="px-4 py-3">
            <input type="text" name="items[new_${timestamp}][hazard_type]" required
                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </td>
        <td class="px-4 py-3">
            <input type="text" name="items[new_${timestamp}][hazard_cause]" required
                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </td>
        <td class="px-4 py-3">
            <input type="text" name="items[new_${timestamp}][risk_factor]" required
                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </td>
        <td class="px-4 py-3">
            <select name="items[new_${timestamp}][probability]" required onchange="updateRiskScore(this.closest('tr'))"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                ${[1,2,3,4,5].map(i => `<option value="${i}">${i}</option>`).join('')}
            </select>
        </td>
        <td class="px-4 py-3">
            <select name="items[new_${timestamp}][severity]" required onchange="updateRiskScore(this.closest('tr'))"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                ${[1,2,3,4,5].map(i => `<option value="${i}">${i}</option>`).join('')}
            </select>
        </td>
        <td class="px-4 py-3">
            <span class="risk-score px-2 py-1 rounded text-sm font-medium" data-score="1">1</span>
        </td>
        <td class="px-4 py-3">
            <input type="text" name="items[new_${timestamp}][reduction_measures]" required
                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </td>
        <td class="px-4 py-3">
            <input type="text" name="items[new_${timestamp}][manager]" required
                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </td>
        <td class="px-4 py-3">
            <button type="button" onclick="this.closest('tr').remove()"
                    class="text-red-600 hover:text-red-900">삭제</button>
        </td>
    `;
    
    tbody.appendChild(newRow);
    updateRiskScore(newRow);
}

function updateRiskScore(row) {
    const probability = parseInt(row.querySelector('[name$="[probability]"]').value);
    const severity = parseInt(row.querySelector('[name$="[severity]"]').value);
    const score = probability * severity;
    const scoreSpan = row.querySelector('.risk-score');
    
    scoreSpan.textContent = score;
    scoreSpan.dataset.score = score;
    
    // 위험도에 따른 색상 변경
    if (score >= 15) {
        scoreSpan.className = 'risk-score px-2 py-1 rounded text-sm font-medium bg-red-100 text-red-800';
    } else if (score >= 8) {
        scoreSpan.className = 'risk-score px-2 py-1 rounded text-sm font-medium bg-yellow-100 text-yellow-800';
    } else {
        scoreSpan.className = 'risk-score px-2 py-1 rounded text-sm font-medium bg-green-100 text-green-800';
    }
}

function saveAssessment() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("risk-assessments.update", $assessment) }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    const method = document.createElement('input');
    method.type = 'hidden';
    method.name = '_method';
    method.value = 'PUT';
    form.appendChild(method);

    // 모든 입력 필드를 복사
    document.querySelectorAll('#assessment-items input, #assessment-items select').forEach(input => {
        const clone = input.cloneNode(true);
        form.appendChild(clone);
    });

    document.body.appendChild(form);
    form.submit();
}

function generatePDF() {
    window.location.href = '{{ route("risk-assessments.pdf", $assessment) }}';
}

// 페이지 로드 시 위험성 점수 색상 초기화
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#assessment-items tr').forEach(row => {
        updateRiskScore(row);
    });
});
</script>
@endpush
@endsection 