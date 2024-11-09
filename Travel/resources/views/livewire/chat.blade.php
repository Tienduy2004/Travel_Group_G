<div class="chat-container">
    <!-- Chat List -->
    @livewire('chat-list')

    <!-- Chat Box -->
    @livewire('chat-box', ['selectedUser' => $selectedUser])
</div>
