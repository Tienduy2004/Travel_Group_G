@extends('layouts.app') <!-- Thay 'layout' bằng tên file layout của bạn nếu khác -->

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Dashboard</h1>
        <div class="card mt-4">
            <div class="card-header">
                <h3>Welcome, {{ auth()->user()->name }}!</h3>
            </div>
            <div class="card-body">
                <p>This is your dashboard where you can manage your account and settings.</p>
                <ul>
                    <li><strong>Email:</strong> {{ auth()->user()->email }}</li>
                    <li><strong>Joined At:</strong> {{ auth()->user()->created_at->format('d/m/Y') }}</li>
                </ul>
                <p>Use the navigation menu to explore more features.</p>
            </div>
        </div>
    </div>
@endsection
