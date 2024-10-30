@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="min-h-screen bg-white">
        <!-- Banner -->
        <div class="relative h-96 bg-gray-100">
            <img src="/img/carousel-1.jpg?height=192&width=1920" alt="Banner" class="w-full h-full object-cover">
        </div>

        <!-- Profile Section -->
        <div class="container max-w-screen-xl mx-auto px-4">
            <div class="relative -mt-12 mb-8 flex items-end gap-4">
                <div class="w-36 h-36 rounded-full border-4 border-white overflow-hidden">
                    <img src="/img/team-1.jpg?height=96&width=96" alt="Profile" class="w-full h-full object-cover">
                </div>
                <div class="mb-2 flex flex-col">
                    <h1 class="text-2xl font-bold">Mohammad Zafar</h1>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        Al Madinah Al Munawwarah, KSA
                    </p>
                </div>
                <div class="ml-auto mb-2 flex items-center gap-2">
                    <div class="rounded-full bg-blue-100 px-3 py-1 text-sm">
                        <span class="font-semibold text-blue-600">2840 PTS</span>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mb-8">
                <div class="border-b">
                    <nav class="flex flex-wrap gap-2 md:gap-4 overflow-auto">
                        <button onclick="showTab('tab-timeline')"
                            class="tab-button px-3 md:px-4 py-2 text-xs md:text-sm font-medium border-b-2 border-transparent hover:border-gray-300">
                            Timeline
                        </button>
                        <button onclick="showTab('tab-booking-history')"
                            class="tab-button px-3 md:px-4 py-2 text-xs md:text-sm font-medium border-b-2 border-transparent hover:border-gray-300">
                            Booking History ({{ count($bookings) }})
                        </button>
                        <button onclick="showTab('tab-new-bookings')"
                            class="tab-button px-3 md:px-4 py-2 text-xs md:text-sm font-medium border-b-2 border-transparent hover:border-gray-300">
                            New Bookings ({{ count($bookingNews) }})
                        </button>
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
@endsection
