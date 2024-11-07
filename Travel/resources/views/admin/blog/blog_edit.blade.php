@extends('layouts.menu')

@section('content')
    <div class="container">
        <h2>Chỉnh Sửa Bài Viết</h2>
        <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tiêu đề -->
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" id="title" name="title" value="{{ $post->title }}" class="form-control" required>
            </div>

            <!-- Nội dung -->
            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea id="content" name="content" rows="5" class="form-control" required>{{ $post->content }}</textarea>
            </div>

            <!-- Ảnh bài viết -->
            <div class="form-group">
                <label for="image_url">Ảnh bài viết</label>
                <input type="file" id="image_url" name="image_url" class="form-control">
                @if($post->image_url)
                    <img src="{{ asset('storage/' . $post->image_url) }}" alt="Image" style="width: 150px; margin-top: 10px;">
                @endif
            </div>

            <!-- Danh mục -->
            <div class="form-group">
                <label for="categories">Danh mục</label>
                <input type="text" id="categories" name="categories" value="{{ $post->categories }}" class="form-control" required>
            </div>

            <!-- Số lượt xem -->
            <div class="form-group">
                <label for="view_count">Số lượt xem</label>
                <input type="number" id="view_count" name="view_count" value="{{ $post->view_count }}" class="form-control">
            </div>

            <!-- Bài viết nổi bật -->
            <div class="form-group">
                <label for="is_featured">Bài viết nổi bật</label>
                <select id="is_featured" name="is_featured" class="form-control">
                    <option value="0" {{ $post->is_featured == 0 ? 'selected' : '' }}>Không</option>
                    <option value="1" {{ $post->is_featured == 1 ? 'selected' : '' }}>Có</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <style>
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }

        .btn {
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            display: inline-block;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
@endsection
