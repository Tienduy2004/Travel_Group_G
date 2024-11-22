<section class="flex-1 p-6">
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($pendingFriendRequests as $FriendRequest)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-4">
                    <div class="flex items-center gap-4">
                        <img alt="{{ $FriendRequest->user->name }}'s avatar" class="rounded-full" height="50"
                            src="{{ asset('/img/profile/avatar/' . $FriendRequest->user->profile->avatar) }}"
                            style="aspect-ratio: 50/50; object-fit: cover;" width="50" />
                        <div class="flex-1">
                            <h3 class="font-semibold">{{ $FriendRequest->user->name }}</h3>
                        </div>
                    </div>
                    <div class="mt-4 grid gap-2">
                        <form action="{{ route('friends.accept') }}" method="POST" class="block w-full text-left">
                            @csrf
                            <input type="hidden" name="friend_id" value="{{ $FriendRequest->user->id }}">
                            <button type="submit"
                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-150 ease-in-out">
                                Xác nhận
                            </button>
                        </form>
                        <form action="{{ route('friends.cancel') }}" method="POST" class="block w-full text-left">
                            @csrf
                            <input type="hidden" name="friend_id" value="{{ $FriendRequest->user->id }}">
                            <button type="submit"
                                class="w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 font-medium rounded-md transition duration-150 ease-in-out">
                                Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
