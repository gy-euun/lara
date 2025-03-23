<!-- A Level Sidebar -->
<div class="w-64 bg-white border-r min-h-screen px-4 py-6">
    <h2 class="text-lg font-bold mb-4">📁 메뉴</h2>
    <ul class="space-y-3 text-gray-800">
        <li>
            <a href="{{ route('projects.create') }}" class="hover:text-blue-500">
                ➕ 프로젝트 생성
            </a>
        </li>

        <li>
            <a href="{{ route('projects.index') }}" class="hover:text-blue-500">
                📋 프로젝트 목록
            </a>
        </li>

        <li>
            <a href="{{ route('community.index') }}"
               class="{{ request()->is('community*') ? 'text-blue-600 font-bold' : '' }}">
                🗨️ 커뮤니티
            </a>
        </li>

        <li>
            <a href="/help" class="hover:text-blue-500">
                ❓ 공지사항 / 도움말
            </a>
        </li>

        <li>
            <a href="{{ route('profile.edit') }}" class="hover:text-blue-500">
                👤 프로필
            </a>
        </li>
    </ul>
</div> 