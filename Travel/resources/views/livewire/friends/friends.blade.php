<div class="p-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Gợi ý kết bạn</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($suggestedFriends as $friend)
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
                <div class="p-6">
                    <div class="flex items-center">
                        <img class="h-16 w-16 rounded-full object-cover border-4 border-blue-500"
                            src="{{ asset('/img/profile/avatar/' . $friend['friend']->profile->avatar) }}"
                            alt="{{ $friend['friend']->name }}">
                        <div class="ml-4">
                            <a href=""><h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $friend['friend']->name }}</h3></a>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $friend['friend']->mutualFriendsCount ?? 0 }}
                                bạn chung</p>
                        </div>
                    </div>
                    <div class="mt-4 flex space-x-4">
                        <button wire:click="sendFriendRequest({{ $friend['friend']->id }})"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Thêm bạn bè
                        </button>
                        <form action="{{ route('message.send') }}" method="POST" class="flex items-center">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $friend['friend']->id }}">
                            <button
                                class="bg-gray-200 text-gray-700 rounded-full px-6 py-2 transition duration-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 flex items-center">
                                <i class="fas fa-comment-dots mr-2"></i> <!-- Biểu tượng nhắn tin -->
                                Nhắn tin
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <p class="text-center text-gray-600 dark:text-gray-400">Không có gợi ý bạn bè.</p>
            </div>
        @endforelse
    </div>
</div>
