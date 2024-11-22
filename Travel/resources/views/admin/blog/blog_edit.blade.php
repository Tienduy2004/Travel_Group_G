@extends('layouts.menu')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Bài Viết</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        form input[type="text"],
        form textarea,
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form textarea {
            resize: vertical;
            height: 150px;
        }

        form input[type="file"] {
            margin-bottom: 15px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #bd2130;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

    </style>
</head>

<body>

    <div class="container">
        <h1>Chỉnh Sửa Bài Viết</h1>
        
        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tiêu đề bài viết -->
            <label for="title">Tiêu Đề</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required>
            @error('title')
            <p class="error-message">{{ $message }}</p>
            @enderror

            <!-- Nội dung bài viết -->
            <label for="content">Nội Dung</label>
            <textarea id="content" name="content" required>{{ old('content', $post->content) }}</textarea>
            @error('content')
            <p class="error-message">{{ $message }}</p>
            @enderror

            <!-- Danh mục -->
            <label for="category_id">Danh Mục</label>
            <select id="category_id" name="category_id" required>
                <option value="">Chọn danh mục</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == old('category_id', $post->category_id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <p class="error-message">{{ $message }}</p>
            @enderror

            <!-- Hình ảnh -->
            <label for="image">Hình Ảnh</label>
            @if($post->image)
            <div>
                <p>Hình ảnh hiện tại:</p>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Ảnh bài viết" style="max-width: 100%; height: auto; margin-bottom: 10px;">
            </div>
            @endif
            <input type="file" id="image" name="image" accept="image/*">
            @error('image')
            <p class="error-message">{{ $message }}</p>
            @enderror

            <!-- Giữ lại hình ảnh hiện tại -->
            <label>
                <input type="checkbox" name="keep_image" value="1"> Giữ lại hình ảnh hiện tại
            </label>

            <!-- Tác giả -->
            <label for="user_id">Tác Giả</label>
            <input type="text" id="user_id" name="user_id" value="{{ old('user_id', $post->user_id) }}" readonly>
            @error('user_id')
            <p class="error-message">{{ $message }}</p>
            @enderror

            <!-- Hành động -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-danger">Hủy</a>
            </div>
        </form>
    </div>

</body>

</html>

@endsection
