<div>
    <h2>Cuộc trò chuyện với Người dùng: {{ $selectedUser }}</h2>
    <ul>
        @foreach($messages as $message)
            <li>{{ $message['sender'] }}: {{ $message['message'] }}</li>
        @endforeach
    </ul>

    <input type="text" wire:model="message" placeholder="Nhập tin nhắn..." />
    <button wire:click="sendMessage">Gửi</button>
</div>
