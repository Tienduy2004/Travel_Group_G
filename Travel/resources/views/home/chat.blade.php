@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Chat</h1>
        
        <x-chat-component :messages="$messages" :receiverId="$receiverId" />
    </div>
@endsection
