@extends('layouts.menu')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Bài Viết</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 30px;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .search-box input[type="text"] {
            padding: 8px;
            font-size: 14px;
            width: 250px;
            border: none;
            outline: none;
            border-radius: 4px;
        }

        .search-box button {
            padding: 8px 16px;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-box button:hover {
            background-color: #0056b3;
        }

        a.btn-primary {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        a.btn-primary:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-btns a,
        .action-btns button {
            display: inline-block;
            margin: 0 5px;
            padding: 8px 12px;
            font-size: 14px;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #bd2130;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <h1>Quản Lý Bài Viết</h1>

    <!-- Toolbar -->
    <div class="toolbar">
        <!-- Search Box -->
        <div class="search-box">
            <form action="{{ route('admin.blog.index') }}" method="GET" style="display: flex; align-items: center;">
                <input type="text" name="search" placeholder="Tìm kiếm bài viết..." value="{{ $search }}">
                <button type="submit">Tìm</button>
            </form>
        </div>

        <!-- Add New Post Button -->
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">Thêm Bài Viết</a>
    </div>

    <!-- Table to show blog posts -->
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tiêu Đề</th>
                <th>Danh Mục</th>
                <th>Tác Giả</th>
                <th>Hình Ảnh</th>
                <th>Nội Dung</th>
                <th>Ngày Tạo</th>
                <th>Ngày Cập Nhật</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->category->name ?? 'Không có danh mục' }}</td>
                <td>{{ $post->user_id }}</td>
                <td>
                    @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Ảnh bài viết" style="width: 80px; height: auto;">
                    @else
                    Không có
                    @endif
                </td>
                <td>{{ Str::limit($post->content, 50, '...') }}</td>
                <td>{{ $post->created_at->format('d/m/Y') }}</td>
                <td>{{ $post->updated_at->format('d/m/Y') }}</td>
                <td class="action-btns">
                    <!-- Edit and Delete Buttons -->
                    <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-warning">✏️</a>
                    <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">🗑️</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center;">Không có bài viết nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        {{ $posts->links() }}
    </div>

</body>

</html>

@endsection
