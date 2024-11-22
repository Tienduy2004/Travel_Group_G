<section class="flex-1 p-6 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Danh sách bạn bè</h2>

        <!-- Danh sách bạn bè -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($allFriends as $item)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <!-- Ảnh đại diện -->
                    <div class="p-4">
                        <div class="flex items-center gap-4">
                            <img alt="{{ $item['friend']->name }}'s avatar"
                                 class="rounded-full h-16 w-16 object-cover border border-gray-300 dark:border-gray-600"
                                 src="{{ asset('/img/profile/avatar/' . $item['friend']->profile->avatar) }}" />
                            <div>
                                <!-- Thẻ liên kết đến trang profile của bạn bè -->
                                <a href="{{ url('profile?id=' . $item['friend']->id) }}" class="font-semibold text-lg text-gray-800 dark:text-white">
                                    {{ $item['friend']->name }}
                                </a>
                                <!-- Thời gian bạn bè -->
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Bạn bè từ {{ $item['friendship']->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Nếu không có bạn bè -->
        @if ($allFriends->isEmpty())
            <div class="mt-6 text-center">
                <p class="text-gray-500 dark:text-gray-300">Bạn chưa có bạn bè nào.</p>
            </div>
        @endif
    </div>
</section>
