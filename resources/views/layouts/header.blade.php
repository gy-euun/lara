<header class="flex justify-between items-center px-6 py-4 bg-white border-b">
    <!-- 로고/서비스명 -->
    <div class="text-xl font-bold text-blue-600">
        My SaaS
    </div>

    <!-- 사용자/설정 영역 -->
    <div class="flex items-center gap-4">
        <!-- 알림 아이콘 -->
        <button class="relative">
            🔔
            <!-- 알림 개수 표시 예시 -->
            <span class="absolute -top-1 -right-1 text-xs bg-red-500 text-white rounded-full px-1">3</span>
        </button>

        <!-- 다크모드/환경 토글 (가짜 버튼) -->
        <button class="text-gray-600 hover:text-black">
            🌓 테마
        </button>

        <!-- 사용자 프로필 -->
        <div class="flex items-center gap-2">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="avatar" class="w-8 h-8 rounded-full">
            <span>{{ Auth::user()->name }}</span>

            <!-- 드롭다운: 프로필/로그아웃 -->
            <div class="relative">
                <button>▼</button>
                <div class="absolute right-0 mt-2 bg-white border rounded shadow p-2 hidden group-hover:block">
                    <a href="{{ route('profile.edit') }}" class="block px-2 py-1 hover:bg-gray-100">프로필</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-2 py-1 hover:bg-gray-100">로그아웃</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header> 