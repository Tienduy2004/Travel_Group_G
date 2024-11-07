@extends('layouts.menu')

@section('content')
    <h1>Thêm Bài Viết Mới</h1>

    <form action="{{ route('admin.blog.store') }}" method="POST">
        @csrf
        <label for="title">Tiêu Đề</label>
        <input type="text" name="title" required>

        <label for="content">Nội Dung</label>
        <textarea name="content" required></textarea>

        <label for="categories">Danh Mục</label>
        <select name="categories[]" multiple>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <button type="submit">Lưu</button>
    </form>
@endsection
