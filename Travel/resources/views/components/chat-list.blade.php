<div class="chat-list">
    @foreach($conversations as $conversation)
        <div class="chat-item">
            <a href="{{ route('chat.show', $conversation->receiver_id) }}">
                <p>{{ $conversation->receiver->name }}</p>
            </a>
        </div>
    @endforeach
</div>
