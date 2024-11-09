@extends('layouts.app')

@section('content')
    <div class="flex justify-between space-x-4 p-6">
        <!-- Danh sách cuộc trò chuyện -->
        <div class="w-1/3 border-r pr-4">
            <h2 class="text-2xl font-semibold mb-6">Danh sách cuộc trò chuyện</h2>
            <!-- Sử dụng component chat-list để hiển thị tất cả cuộc trò chuyện -->
            <livewire:chat-list />
        </div>

        <!-- Khung chat -->
        <div class="w-2/3 pl-4">
            <h2 class="text-2xl font-semibold mb-6">Cuộc trò chuyện</h2>
            <!-- Sử dụng component chat-box để hiển thị cuộc trò chuyện với người dùng được chọn -->
            <livewire:chat-box :conversation-id="$conversationId" />
        </div>
    </div>
@endsection
