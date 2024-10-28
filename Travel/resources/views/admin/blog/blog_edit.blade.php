@extends('layouts.menu')

@section('content')
    <h1>Sửa Bài Viết</h1>

    <form action="{{ route('admin.blog.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="title">Tiêu Đề:</label>
            <input type="text" name="title" value="{{ $post->title }}" required>
        </div>

        <div>
            <label for="content">Nội Dung:</label>
            <textarea name="content" required>{{ $post->content }}</textarea>
        </div>

        <div>
            <label for="user_id">User ID:</label>
            <input type="number" name="user_id" value="{{ $post->user_id }}" required>
        </div>

        <button type="submit">Cập Nhật</button>
    </form>
@endsection