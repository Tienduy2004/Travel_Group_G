@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="min-h-screen bg-white">
        <div class="relative h-96 bg-gray-900 rounded-lg overflow-hidden">
            {{-- Cover Photo Display --}}
            @if ($profile->cover_photo)
                <img src="{{ asset('/img/profile/cover/' . $profile->cover_photo) }}" alt="Banner"
                    class="w-full h-full object-cover object-center transition-opacity duration-300">
            @else
                <div class="w-full h-full bg-gradient-to-b from-gray-800 to-gray-900 flex items-center justify-center">
                    <span class="text-gray-400">No cover photo</span>
                </div>
            @endif
            @if ($profile->user_id == auth()->user()->id)
                {{-- Upload Form --}}
                <form action="{{ route('profile.update.cover', $profile->id) }}" method="POST" enctype="multipart/form-data"
                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 hover:opacity-100 transition-opacity duration-300">
                    @csrf
                    <div class="flex flex-col items-center space-y-4">
                        <label for="cover_photo"
                            class="px-6 py-3 bg-white/90 hover:bg-white text-gray-900 rounded-lg cursor-pointer transition-colors duration-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path
                                    d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                                <circle cx="12" cy="13" r="4" />
                            </svg>
                            <span>Chọn ảnh bìa</span>
                        </label>
                        <input type="file" id="cover_photo" name="cover_photo" accept="image/*" required class="hidden"
                            onchange="this.form.submit()">
                    </div>
                </form>
            @endif

            {{-- Error Messages --}}
            @error('cover_photo')
                <div class="absolute bottom-4 left-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg">
                    {{ $message }}
                </div>
            @enderror
        </div>



        <!-- Profile Section -->
        <div class="container max-w-screen-xl mx-auto px-4">
            <div class="relative -mt-12 mb-8 flex items-end gap-4">
                <div class="relative flex">
                    <div>
                        @if ($profile->avatar)
                            {{-- Avatar Container --}}
                            <div class="w-40 h-40 rounded-full border-4 border-white overflow-hidden relative">
                                <img src="{{ asset('/img/profile/avatar/' . $profile->avatar) }}?height=96&width=96"
                                    alt="Profile" class="w-full h-full object-cover">
                            </div>
                        @else
                            {{-- Avatar Container --}}
                            <div class="w-40 h-40 rounded-full border-4 border-white overflow-hidden relative">
                                <img src="{{ asset('/img/profile/avater.png') }}?height=96&width=96" alt="Profile"
                                    class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>
                    @if ($profile->user_id == auth()->user()->id)
                        {{-- Camera Icon Overlay --}}
                        <form action="{{ route('profile.update.avatar', $profile->id) }}" method="POST"
                            enctype="multipart/form-data"
                            class="absolute w-9 h-9 top-28 right-2 items-center justify-center bg-gray-400 rounded-full p-1">
                            @csrf
                            <label for="avatar" class="flex items-center justify-center cursor-pointer text-white h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                                    <circle cx="12" cy="13" r="4" />
                                </svg>
                                <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden"
                                    onchange="this.form.submit()">
                            </label>
                        </form>
                    @endif
                </div>



                {{-- User Information --}}
                <div class="mb-8 flex flex-col">
                    <h1 class="text-2xl mb-2 font-bold">{{ $profile->user->name }}</h1>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        {{ $profile->bio }}
                    </p>
                </div>
                {{-- <div class="container mx-auto">
                    <h1 class="text-2xl font-bold mb-4">Chat</h1>
                    
                    <x-chat-component :messages="$messages" :receiverId="$receiverId" />
                </div> --}}


                @if ($profile->user_id != auth()->user()->id)
                    <div class="ml-auto mb-2 flex items-center gap-2">
                        <div class="flex space-x-3">
                            @if ($friendship)
                                @if ($friendship->status == 'pending')
                                    @if ($isInitiator)
                                        <!-- Nút Phản hồi với toggle menu -->
                                        <div class="relative">
                                            <button onclick="toggleMenu(event)"
                                                class="bg-blue-500 text-white rounded-full px-6 py-2 transition duration-200 hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center">
                                                <i class="fas fa-user-times mr-2"></i> <!-- Biểu tượng hủy -->
                                                Phản hồi
                                            </button>
                                            <!-- Menu tùy chọn bật lên với mũi tên -->
                                            <div id="toggleOptionsMenu"
                                                class="hidden absolute left-0 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg z-10 p-1.5">
                                                <!-- Phần mũi tên -->
                                                <div
                                                    class="absolute -top-2 left-4 w-3 h-3 bg-white transform rotate-45 border-t border-l border-gray-300">
                                                </div>

                                                <!-- Nội dung menu -->
                                                <form action="{{ route('friends.accept') }}" method="POST"
                                                    class="block w-full text-left">
                                                    @csrf
                                                    <input type="hidden" name="friend_id" value="{{ $profile->user_id }}">
                                                    <button type="submit"
                                                        class="block w-full px-4 py-2 text-gray-800 hover:bg-gray-100">Xác
                                                        nhận</button>
                                                </form>
                                                <form action="{{ route('friends.cancel') }}" method="POST"
                                                    class="block w-full text-left">
                                                    @csrf
                                                    <input type="hidden" name="friend_id" value="{{ $profile->user_id }}">
                                                    <button type="submit"
                                                        class="block w-full px-4 py-2 text-gray-800 hover:bg-gray-100">Hủy
                                                        lời mời</button>
                                                </form>
                                            </div>
                                        </div>
                                        <form action="{{  route('message.send') }}" method="POST" class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $profile->user_id }}">
                                            <button
                                                class="bg-blue-500 text-white rounded-full px-6 py-2 transition duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 flex items-center">
                                                <i class="fas fa-comment-dots mr-2"></i> <!-- Biểu tượng nhắn tin -->
                                                Nhắn tin
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('friends.cancelInvitation') }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="friend_id" value="{{ $profile->user_id }}">
                                            <button type="submit"
                                                class="bg-gray-500 text-white rounded-full px-6 py-2 transition duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center">
                                                <i class="fas fa-user-times mr-2"></i> <!-- Biểu tượng hủy -->
                                                Hủy lời mời
                                            </button>
                                        </form>

                                        <form action="{{  route('message.send') }}" method="POST" class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $profile->user_id }}">
                                            <button
                                                class="bg-blue-500 text-white rounded-full px-6 py-2 transition duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 flex items-center">
                                                <i class="fas fa-comment-dots mr-2"></i> <!-- Biểu tượng nhắn tin -->
                                                Nhắn tin
                                            </button>
                                        </form>
                                    @endif
                                @elseif($friendship->status == 'accepted')
                                    <!-- Nút Phản hồi với toggle menu -->
                                    <div class="relative">
                                        <button onclick="toggleMenu(event)"
                                            class="bg-gray-500 text-white rounded-full px-6 py-2 transition duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center">
                                            <i class="fas fa-user-friends mr-2"></i> <!-- Biểu tượng bạn bè -->
                                            Bạn bè
                                        </button>
                                        <!-- Menu tùy chọn bật lên với mũi tên -->
                                        <div id="toggleOptionsMenu"
                                            class="hidden absolute left-0 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg z-10 p-1.5">
                                            <!-- Phần mũi tên -->
                                            <div
                                                class="absolute -top-2 left-4 w-3 h-3 bg-white transform rotate-45 border-t border-l border-gray-300">
                                            </div>

                                            <!-- Nội dung menu -->
                                            <form action="{{ route('friends.cancel') }}" method="POST"
                                                class="block w-full text-left">
                                                @csrf
                                                <input type="hidden" name="friend_id" value="{{ $profile->user_id }}">
                                                <button type="submit"
                                                    class="block w-full px-4 py-2 text-gray-800 hover:bg-gray-100">Hủy
                                                    bạn bè</button>
                                            </form>
                                        </div>
                                    </div>
                                    <form action="{{  route('message.send') }}" method="POST" class="flex items-center">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $profile->user_id }}">
                                        <button
                                            class="bg-blue-500 text-white rounded-full px-6 py-2 transition duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 flex items-center">
                                            <i class="fas fa-comment-dots mr-2"></i> <!-- Biểu tượng nhắn tin -->
                                            Nhắn tin
                                        </button>
                                    </form>
                                @endif
                            @else
                                <form action="{{ route('friends.add') }}" method="POST" class="flex items-center">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $profile->user_id }}">
                                    <button type="submit"
                                        class="bg-blue-500 text-white rounded-full px-6 py-2 transition duration-200 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center">
                                        <i class="fas fa-user-plus mr-2"></i> <!-- Biểu tượng thêm bạn -->
                                        Thêm bạn bè
                                    </button>
                                </form>
                                <form action="{{  route('message.send') }}" method="POST" class="flex items-center">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $profile->user_id }}">
                                    <button
                                        class="bg-blue-500 text-white rounded-full px-6 py-2 transition duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 flex items-center">
                                        <i class="fas fa-comment-dots mr-2"></i> <!-- Biểu tượng nhắn tin -->
                                        Nhắn tin
                                    </button>
                                </form>
                                
                                
                                
                                
                            @endif
                        </div>
                    </div>
                @endif

            </div>




            <!-- Tabs -->
            <div class="mb-8">
                <div class="border-b">
                    <nav class="flex flex-wrap gap-2 md:gap-4 overflow-auto">
                        <button onclick="showTab('tab-timeline')"
                            class="tab-button px-3 md:px-4 py-2 text-xs md:text-sm font-medium border-b-2 border-transparent hover:border-gray-300">
                            Timeline
                        </button>
                        @if ($profile->user_id == auth()->user()->id)
                            <button onclick="showTab('tab-booking-history')"
                                class="tab-button px-3 md:px-4 py-2 text-xs md:text-sm font-medium border-b-2 border-transparent hover:border-gray-300">
                                Booking History ({{ count($bookings) }})
                            </button>
                            <button onclick="showTab('tab-new-bookings')"
                                class="tab-button px-3 md:px-4 py-2 text-xs md:text-sm font-medium border-b-2 border-transparent hover:border-gray-300">
                                New Bookings ({{ count($bookingNews) }})
                            </button>
                            <button onclick="showTab('tab-friends')"
                                class="tab-button px-3 md:px-4 py-2 text-xs md:text-sm font-medium border-b-2 border-transparent hover:border-gray-300">
                                Friends
                            </button>
                        @endif
                        <button onclick="showTab('tab-favourites')"
                            class="tab-button px-3 md:px-4 py-2 text-xs md:text-sm font-medium border-b-2 border-transparent hover:border-gray-300">
                            My Favourites (7)
                        </button>
                        <button onclick="showTab('tab-account-settings')"
                            class="tab-button px-3 md:px-4 py-2 text-xs md:text-sm font-medium border-b-2 border-transparent hover:border-gray-300">
                            Account Settings
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div id="tab-timeline" class="tab-content mt-4">
                    <p>Timeline content here...</p>
                    
                </div>

                <div id="tab-booking-history" class="tab-content mt-4" style="display: none;">
                    <p>Booking History content here...</p>
                    <x-booking-history :bookings="$bookings" />
                </div>
                <div id="tab-new-bookings" class="tab-content mt-4" style="display: none;">
                    <x-booking-history :bookings="$bookingNews" />
                </div>
                <div id="tab-friends" class="tab-content mt-4" style="display: none;">
                    <x-friend-list />
                </div>
                <div id="tab-favourites" class="tab-content mt-4" style="display: none;">
                    <p>My Favourites content here...</p>
                </div>
                <div id="tab-account-settings" class="tab-content mt-4" style="display: none;">
                    <p>Account settings content here...</p>
                </div>
            </div>

            <!-- Featured Partners -->
            <section class="py-12 border-t">
                <h2 class="text-2xl font-semibold text-center mb-2">Featured & Co. Partners</h2>
                <p class="text-center text-gray-500 mb-8 max-w-2xl mx-auto">
                    World's #1 website for halal-friendly hotels and villas - search by your needs: halal food, no-alcohol,
                    women-only pools, spas and beaches. Best prices guaranteed!
                </p>
                <div class="flex flex-wrap justify-center gap-8 opacity-75">
                    <div class="text-xl font-serif font-medium">The Guardian</div>
                    <div class="text-xl font-serif font-medium">BBC</div>
                    <div class="text-xl font-serif font-medium">TRT World</div>
                    <div class="text-xl font-serif font-medium">Al Jazeera</div>
                    <div class="text-xl font-serif font-medium">The New York Times</div>
                </div>
            </section>

            <section class="py-12 border-t">
                <h2 class="text-2xl font-semibold text-center mb-2">Popular Halal Destinations</h2>
                <p class="text-center text-gray-500 mb-8">
                    Below is a select range of properties around the world demonstrating various halal features
                </p>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @if ($latestTours->isEmpty())
                        <div class="col-span-full text-center">
                            <h4 class="text-red-600">There are no tours</h4>
                        </div>
                    @else
                        @foreach ($latestTours as $tour)
                            <div class="bg-white border rounded-lg shadow">
                                <div class="h-48 overflow-hidden rounded-t-lg">
                                    <img class="w-full h-full object-cover"
                                        src="{{ asset('img/tours/' . $tour->image_main) }}" alt="{{ $tour->name }}"
                                        loading="lazy">
                                </div>

                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-3 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <i class="fa fa-map-marker-alt text-primary mr-2"></i>
                                            <span>{{ $tour->destination->name ?? 'Unknown Destination' }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fa fa-calendar-alt text-primary mr-2"></i>
                                            <span>{{ $tour->number_days }} days</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fa fa-user text-primary mr-2"></i>
                                            <span>{{ $tour->person }} Person</span>
                                        </div>
                                    </div>
                                    <a class="text-lg font-semibold text-blue-600 hover:underline"
                                        href="{{ route('tours.show', ['slug' => $tour->slug]) }}">
                                        {{ $tour->name }}
                                    </a>
                                    <div class="border-t mt-4 pt-4">
                                        <div class="flex justify-between items-center">
                                            <h5 class="text-gray-700">Price:</h5>
                                            <h5 class="text-gray-900 font-semibold">{{ number_format($tour->price) }} VND
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </section>
        </div>
    </div>
    <script>
        function showTab(tabId) {
            // Ẩn tất cả các tab
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });
            // Hiển thị tab được chọn
            document.getElementById(tabId).style.display = 'block';

            // Thêm lớp cho tab đang chọn
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-blue-600', 'text-blue-600');
            });
            event.target.classList.add('border-blue-600', 'text-blue-600');
        }
    </script>
    <script>
        function toggleMenu(event) {
            const menu = document.getElementById('toggleOptionsMenu');
            menu.classList.toggle('hidden');
            event.stopPropagation(); // Ngăn chặn sự kiện click lan ra ngoài
        }

        // Đóng menu khi nhấn vào bất kỳ chỗ nào khác trên trang
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('toggleOptionsMenu');
            const button = document.querySelector('button[onclick="toggleMenu(event)"]');
            if (!menu.classList.contains('hidden') && !menu.contains(event.target) && event.target !== button) {
                menu.classList.add('hidden');
            }
        });
    </script>
@endsection
