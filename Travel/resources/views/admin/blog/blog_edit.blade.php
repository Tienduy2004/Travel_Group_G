@extends('layouts.menu')

@section('content')
    <h1 class="text-center" style="color: #333; margin-top: 20px;">Chỉnh Sửa Bài Viết</h1>

    <!-- Hiển thị lỗi nếu có -->
    @if ($errors->any())
        <div class="alert alert-danger" style="padding: 10px; background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; border-radius: 8px; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" style="max-width: 600px; margin: 0 auto;">
        @csrf
        @method('PUT')

        <!-- Tiêu đề bài viết -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="title" style="font-weight: bold; color: #333;">Tiêu Đề</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $post->title) }}" placeholder="Nhập tiêu đề bài viết..." required>
        </div>

        <!-- Nội dung bài viết -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="content" style="font-weight: bold; color: #333;">Nội Dung</label>
            <textarea id="content" name="content" class="form-control" rows="5" placeholder="Nhập nội dung bài viết..." required>{{ old('content', $post->content) }}</textarea>
        </div>

        <!-- Danh mục bài viết -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="category_id" style="font-weight: bold; color: #333;">Danh Mục</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Nút cập nhật và quay lại -->
        <button type="submit" class="btn btn-warning" style="font-size: 16px; padding: 10px 20px; border-radius: 8px; width: 100%;">Cập Nhật Bài Viết</button>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary" style="font-size: 16px; padding: 10px 20px; border-radius: 8px; display: block; margin-top: 10px; text-align: center;">Quay lại</a>
    </form>

    <style>
        .form-control {
            font-size: 16px;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 100%;
        }

        .btn-warning {
            background-color: #ffc107;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .alert {
            font-size: 16px;
            border-radius: 8px;
        }
    </style>
@endsection
