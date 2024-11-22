<div class="grid min-h-screen w-full lg:grid-cols-[280px_1fr]">
    <nav class="hidden border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 lg:block">
        <div class="flex h-full flex-col">
            <div class="flex h-[60px] items-center border-b border-gray-200 dark:border-gray-700 px-6">
                <h2 class="text-lg font-semibold">Bạn bè</h2>
            </div>
            <div class="flex-1 px-3 py-2">
                <ul class="space-y-1">
                    <li>
                        <a wire:click="setTag('home')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 
                                  {{ $selectedTag === 'home' ? 'bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-500 dark:text-gray-400' }} 
                                  hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <a wire:click="setTag('friend-requests')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 
                                  {{ $selectedTag === 'friend-requests' ? 'bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-500 dark:text-gray-400' }} 
                                  hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                            </svg>
                            Lời mời kết bạn
                        </a>
                    </li>
                    <li>
                        <a wire:click="setTag('friends')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 
                                  {{ $selectedTag === 'friends' ? 'bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-500 dark:text-gray-400' }} 
                                  hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                            Gợi ý
                        </a>
                    </li>
                    <li>
                        <a wire:click="setTag('all-friends')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 
                                  {{ $selectedTag === 'all-friends' ? 'bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-500 dark:text-gray-400' }} 
                                  hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                            Tất cả bạn bè
                        </a>
                    </li>
                    <li>
                        <a wire:click="setTag('birthday-friends')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 
                                  {{ $selectedTag === 'birthday-friends' ? 'bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-500 dark:text-gray-400' }} 
                                  hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                            Sinh nhật
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <main class="flex flex-col">
        <header
            class="flex h-14 items-center gap-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-6">
            <h1 class="text-lg font-semibold">{{ $title }}</h1>
            {{-- <a href="#" class="ml-auto text-sm text-blue-600 dark:text-blue-400 hover:underline">Xem tất cả</a> --}}
        </header>

        <!-- Nội dung của các tab -->
        <div>
            @if ($selectedTag === 'friend-requests')
                <livewire:friends.friend-requests />
            @elseif ($selectedTag === 'all-friends')
                <livewire:friends.all-friends />
            @elseif ($selectedTag === 'friends')
                <livewire:friends.friends :user-id="auth()->id()"/>
            @elseif ($selectedTag === 'birthday-friends')
                <livewire:friends.birthday-friends />
            @else
                <!-- Nội dung mặc định, ví dụ "Trang chủ" -->
                <livewire:friends.friend-requests />

            @endif
        </div>
    </main>
</div>
