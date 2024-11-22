{{-- <body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="grid min-h-screen w-full lg:grid-cols-[280px_1fr_280px]">
        <!-- Left Sidebar -->
        <aside class="hidden lg:block border-r border-gray-200 dark:border-gray-800 overflow-y-auto">
            <div class="p-4 space-y-4">
                <div class="flex items-center gap-3 px-2 py-1">
                    <img src="https://via.placeholder.com/40" alt="Tiến Duy" class="rounded-full">
                    <span class="text-sm font-medium">Tiến Duy</span>
                </div>
                <nav class="space-y-1">
                    @foreach(['Bạn bè', 'Nhóm', 'Video', 'Đã lưu', 'Sự kiện', 'Sinh nhật', 'Kỷ niệm'] as $item)
                        <a href="#" class="flex items-center gap-3 px-2 py-2 text-sm rounded-md hover:bg-gray-200 dark:hover:bg-gray-800">
                            <i class="fas fa-users w-5"></i>
                            {{ $item }}
                        </a>
                    @endforeach
                    <a href="#" class="flex items-center gap-3 px-2 py-2 text-sm rounded-md hover:bg-gray-200 dark:hover:bg-gray-800">
                        <i class="fas fa-chevron-down w-5"></i>
                        Xem thêm
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 py-4 overflow-y-auto">
            <div class="container max-w-3xl mx-auto space-y-4">
                <!-- Status Update Box -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 space-y-4">
                    <div class="flex gap-2">
                        <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-full">
                        <input type="text" placeholder="Duy ơi, bạn đang nghĩ gì thế?" class="w-full bg-gray-100 dark:bg-gray-700 rounded-full px-4">
                    </div>
                    <div class="flex gap-2 pt-2 border-t">
                        <button class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <i class="fas fa-video text-red-500"></i>
                            Video trực tiếp
                        </button>
                        <button class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <i class="fas fa-images text-green-500"></i>
                            Ảnh/video
                        </button>
                        <button class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <i class="fas fa-smile text-yellow-500"></i>
                            Cảm xúc/hoạt động
                        </button>
                    </div>
                </div>

                <!-- Stories -->
                <div class="flex gap-2 overflow-x-auto p-1">
                    <div class="w-[120px] h-[200px] bg-white dark:bg-gray-800 rounded-lg shadow flex flex-col items-center justify-center relative shrink-0">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span class="mt-2 text-sm font-medium">Tạo tin</span>
                    </div>
                    @foreach(['Như Ý', 'Huỳnh Thùy Dương', 'Hà Linh', 'Đỗ Thị Mỹ Hiệp'] as $name)
                        <div class="w-[120px] h-[200px] bg-gray-300 dark:bg-gray-700 rounded-lg shadow relative shrink-0">
                            <img src="https://via.placeholder.com/120x200" alt="{{ $name }}" class="w-full h-full object-cover rounded-lg">
                            <div class="absolute top-2 left-2 w-8 h-8 bg-blue-500 rounded-full border-2 border-white"></div>
                            <div class="absolute bottom-2 left-2 right-2">
                                <span class="text-sm font-medium text-white">{{ $name }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Posts -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-4 flex items-center gap-3">
                        <img src="https://via.placeholder.com/40" alt="Sang Nguyen" class="rounded-full">
                        <div class="flex-1">
                            <h3 class="font-semibold">Mua Bán Trao Đổi Mô Hình Anime Giá Rẻ</h3>
                            <p class="text-sm text-gray-500">Sang Nguyen · 27 phút</p>
                        </div>
                        <button class="text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-full">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <button class="text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-full">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="px-4 pb-4">
                        <p>Combo xanh đỏ</p>
                        <div class="mt-3 grid grid-cols-2 gap-1">
                            <img src="https://via.placeholder.com/300" alt="Post image 1" class="w-full aspect-square object-cover">
                            <img src="https://via.placeholder.com/300" alt="Post image 2" class="w-full aspect-square object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        <aside class="hidden lg:block border-l border-gray-200 dark:border-gray-800 overflow-y-auto">
            <div class="p-4 space-y-4">
                <div>
                    <h3 class="font-semibold mb-3">Được tài trợ</h3>
                    <div class="space-y-4">
                        <div class="flex gap-2">
                            <img src="https://via.placeholder.com/120" alt="Ad 1" class="rounded-lg w-[120px] h-[120px] object-cover">
                            <div>
                                <h4 class="font-medium">Lalarosedayvietnam</h4>
                                <p class="text-sm text-gray-500">shopee.vn</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <img src="https://via.placeholder.com/120" alt="Ad 2" class="rounded-lg w-[120px] h-[120px] object-cover">
                            <div>
                                <h4 class="font-medium">BLACK FRIDAY | THỜI TRANG MÃI CHỐT ĐƠN KHÔNG PHÍ SHIP</h4>
                                <p class="text-sm text-gray-500">lug.vn</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold">Người liên hệ</h3>
                        <button class="text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-full">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="space-y-2">
                        @foreach(['Lý Thanh Hùng', 'Khắc Quang', 'Ngô Văn Thân', 'Nguyen Tran Dang Khoa', 'Nguyễn Bá Thắng'] as $name)
                            <a href="#" class="flex items-center gap-2 px-2 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                                <img src="https://via.placeholder.com/32" alt="{{ $name }}" class="rounded-full w-8 h-8">
                                <span class="text-sm font-medium">{{ $name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>
    </div>
</body>
 --}}
 <div>Home</div>
