@php
    //dd($friends);
@endphp
<div class="friend-list max-w-6xl p-4">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Danh sách bạn bè</h2>
    <ul class="grid grid-cols-2 gap-4 max-h-96 overflow-y-auto">
        @forelse($friends as $friend)
            <li class="flex items-center p-4 border border-gray-300 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <!-- Hiển thị ảnh đại diện nếu có -->
                @if ($friend->profile->avatar)
                    {{-- Avatar Container --}}
                    <div class="w-16 h-16 rounded-full border-4 border-white overflow-hidden relative mr-4">
                        <img src="{{ asset('/img/profile/avatar/' . $friend->profile->avatar) }}" alt="Profile"
                            class="w-full h-full object-cover">
                    </div>
                @else
                    {{-- Avatar Container --}}
                    <div class="w-16 h-16 rounded-full border-4 border-white overflow-hidden relative mr-4">
                        <img src="{{ asset('/img/profile/avatar_default.png') }}" alt="Profile"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Tên bạn bè -->
                <div class="flex-1">
                    <p class="text-xl font-medium text-gray-900">{{ $friend->name }}</p>
                </div>

                <!-- Các nút hành động -->
                <div class="relative">
                    <button class="text-gray-800 px-2 py-2 focus:outline-none" id="dropdownButton-{{ $friend->id }}">
                        <span class="text-xl">...</span>
                    </button>
                    <div class="absolute right-0 mt-1 w-48 bg-white rounded-md shadow-lg hidden" id="dropdownMenu-{{ $friend->id }}">
                        <ul class="py-1">
                            <li><a href="" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Xem hồ sơ</a></li>
                            <li><a href="" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Xóa bạn</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        @empty
            <li class="text-gray-500 col-span-2">Không có bạn bè nào trong danh sách.</li>
        @endforelse
        
    </ul>
</div>
<script>
    document.querySelectorAll('[id^="dropdownButton-"]').forEach(button => {
        button.addEventListener('click', function() {
            const friendId = this.id.split('-')[1];
            const menu = document.getElementById(`dropdownMenu-${friendId}`);
            menu.classList.toggle('hidden');
        });
    });

    // Đóng menu khi nhấn ra ngoài
    window.addEventListener('click', function(event) {
        if (!event.target.matches('[id^="dropdownButton-"]')) {
            document.querySelectorAll('[id^="dropdownMenu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
</script>
