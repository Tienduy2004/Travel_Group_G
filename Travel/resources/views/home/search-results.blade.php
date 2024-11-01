@extends('layouts.app') <!-- Thay đổi theo layout của bạn -->

@section('content')
<link href="{{ asset('css/tailwind/tailwind.min.css') }}" rel="stylesheet">
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-green-500 mb-6 text-center">Kết Quả Tìm Kiếm</h1>
    <!-- Search Tour -->
    <x-search-tour />
    <!-- Search Tour -->
    @if($results->isEmpty())
        <p class="text-gray-500 text-center">Không tìm thấy tour nào phù hợp với yêu cầu của bạn.</p>
    @else
    <section class="py-12 border-t">
        <h2 class="text-2xl font-semibold text-center mb-4">Các Điểm Đến Phổ Biến</h2>
        <p class="text-center text-gray-500 mb-8">
            Dưới đây là danh sách các tour du lịch hấp dẫn phù hợp với yêu cầu của bạn.
        </p>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($results as $tour)
                <div class="bg-white border border-gray-200 rounded-lg shadow-lg transition-transform transform hover:scale-105 duration-300">
                    <div class="h-72 overflow-hidden rounded-t-lg">
                        <img class="w-full h-full object-cover"
                            src="{{ asset('img/tours/' . $tour->image_main) }}" alt="{{ $tour->name }}"
                            loading="lazy">
                    </div>

                    <div class="p-4">
                        <div class="flex justify-between items-center mb-3 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                <span>{{ $tour->destination->name ?? 'Unknown Destination' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-green-500 mr-2"></i>
                                <span>{{ $tour->number_days }} ngày</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-user text-green-500 mr-2"></i>
                                <span>{{ $tour->person }} Người</span>
                            </div>
                        </div>
                        <a class="text-lg font-semibold text-blue-600 hover:underline"
                            href="{{ route('tours.show', ['slug' => $tour->slug]) }}">
                            {{ $tour->name }}
                        </a>
                        <div class="border-t mt-4 pt-4">
                            <div class="flex justify-between items-center">
                                <h5 class="text-gray-700">Giá:</h5>
                                <h5 class="text-gray-900 font-semibold">{{ number_format($tour->price) }} VND</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </section>
    @endif
</div>
@endsection
