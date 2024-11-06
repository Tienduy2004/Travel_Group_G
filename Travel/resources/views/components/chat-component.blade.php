
    <div id="chat" class="bg-gray-100 p-4 rounded-lg shadow-md" data-receiver-id="{{ $receiverId }}">
        <div id="messages" class="h-80 overflow-y-auto mb-4 p-2 bg-white rounded-lg">
            @foreach ($messages as $message)
                <div class="{{ $message->sender_id == auth()->id() ? 'sent' : 'received' }} mb-2">
                    <p class="p-2 rounded-lg {{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-300' }}">
                        {{ $message->message }}
                    </p>
                    <span class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</span>
                </div>
            @endforeach
        </div>

        <div class="flex">
            <input type="text" id="message-input" class="flex-1 p-2 border rounded-lg" placeholder="Type your message..." />
            <button id="send-button" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg">Send</button>
        </div>
    </div>


    @vite('resources/js/app.js')

