import './bootstrap';

import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

window.Alpine = Alpine;
Alpine.start();

window.Pusher = Pusher;




window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    },
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
    },
});

const chatDiv = document.getElementById('chat');
const receiverId = chatDiv.getAttribute('data-receiver-id');
// Lắng nghe sự kiện 'MessageSent' trên kênh riêng 'chat.{receiverId}'
window.Echo.private(`chat.${receiverId}`)
    .listen('MessageSent', (e) => {
        const messagesDiv = document.getElementById('messages');
        const newMessage = document.createElement('div');
        newMessage.classList.add(e.message.sender_id === parseInt(receiverId) ? 'received' : 'sent', 'mb-2');
        newMessage.innerHTML = `
            <p class="p-2 rounded-lg ${e.message.sender_id === parseInt(receiverId) ? 'bg-gray-300' : 'bg-blue-500 text-white'}">${e.message.message}</p>
            <span class="text-xs text-gray-500">${new Date(e.message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
        `;
        messagesDiv.appendChild(newMessage);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    });

// Gửi tin nhắn
document.getElementById('send-button').addEventListener('click', function() {
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value;

    if (message.trim() === '') {
        return;
    }

    axios.post('/chat/send-message', {
        message: message,
        receiver_id: receiverId,
    })
    .then(response => {
        messageInput.value = ''; // Clear input
    })
    .catch(error => {
        console.error(error);
    });
});