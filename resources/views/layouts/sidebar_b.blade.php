<!-- B Level Sidebar -->
<div class="w-64 bg-white border-r min-h-screen px-4 py-6">
    <h2 class="text-lg font-bold mb-4">📂 프로젝트 메뉴</h2>
    <ul class="space-y-3 text-gray-800">
        <li>
            <a href="{{ route('projects.risk-assessments.index', $project) }}" class="hover:text-blue-500">
                🧯 위험성 평가
            </a>
        </li>
        <li>
            <a href="{{ route('projects.workers.index', $project) }}" class="hover:text-blue-500">
                👷 근로자 관리
            </a>
        </li>
        <li>
            <a href="{{ route('projects.documents.index', $project) }}" class="hover:text-blue-500">
                📂 문서 관리
            </a>
        </li>
        <li>
            <a href="{{ route('projects.chatbot.index', $project) }}" class="hover:text-blue-500">
                🤖 캐릭터 챗봇
            </a>
        </li>
    </ul>
</div> 