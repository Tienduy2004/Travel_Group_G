<div class="chat-box">
    @foreach($messages as $message)
        <div class="message">
            <strong>{{ $message->sender->name }}:</strong>
            <p>{{ $message->content }}</p>
        </div>
    @endforeach

    <form action="{{ route('messages.send') }}" method="POST">
        @csrf
        <textarea name="content" placeholder="Enter your message..."></textarea>
        <button type="submit">Send</button>
    </form>
</div>
