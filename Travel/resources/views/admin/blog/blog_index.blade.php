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
                background-color: #cdadad;
                font-family: Arial, sans-serif;
                margin: 0;
            }

            h1 {
                text-align: center;
                color: #333;
            }

            .toolbar {
                display: flex;
                justify-content: space-between;
                margin-bottom: 15px;
            }

            .search-box {
                display: flex;
                align-items: center;
                gap: 10px;
                flex-grow: 1;
            }

            .search-box input[type="text"] {
                padding: 8px;
                font-size: 16px;
                width: 100%;
                max-width: 300px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .search-box button {
                padding: 8px 16px;
                font-size: 16px;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .search-box button:hover {
                background-color: #218838;
            }

            a.btn-primary {
                background-color: #007bff;
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-size: 18px;
                text-align: left;
                background-color: #ffffff;
            }

            th,
            td {
                padding: 12px;
                border: 1px solid #dddddd;
            }

            th {
                background-color: #007bff;
                color: #ffffff;
            }

            tr:nth-child(even) {
                background-color: #f7d7d7;
            }

            tr:hover {
                background-color: #f7f4f4;
            }

            .action-btns {
                display: flex;
                gap: 10px;
            }

            .action-btns a,
            .action-btns button {
                border: none;
                background: none;
                cursor: pointer;
            }

            .btn-warning {
                color: #ffc107;
            }

            .btn-danger {
                color: red;
            }

            .pagination {
                display: flex;
                justify-content: center;
                margin-top: 20px;
                list-style: none;
                padding: 0;
                margin: 1rem 0;
            }

            .pagination li {
                margin: 0 3px;
            }

            .pagination a,
            .pagination span {
                display: inline-block;
                padding: 6px 12px;
                font-size: 14px;
                color: #007bff;
                text-decoration: none;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            .pagination a:hover {
                background-color: #f1f1f1;
                border-color: #007bff;
            }

            .pagination .active span {
                background-color: #007bff;
                color: white;
                border-color: #007bff;
            }

            .pagination .disabled span {
                color: #6c757d;
                pointer-events: none;
                background-color: #f8f9fa;
                border-color: #ddd;
            }

            .pagination-summary,
            .pagination-text {
                display: none !important;
            }

            img {
                width: 100px; /* Kích thước hình ảnh */
                height: auto;
            }
        </style>
    </head>

    <body>
        <h1>Quản Lý Bài Viết</h1>

        <div class="toolbar">
            <div class="search-box">
                <input type="text" placeholder="Tìm kiếm bài viết...">
                <button type="button">Tìm kiếm</button>
            </div>
            <a href="{{ url('/managementblog/create') }}" class="btn btn-primary">Thêm Bài Viết</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Thể Loại</th>
                    <th>Tiêu Đề</th>
                    <th>Nội Dung</th>
                    <th>URL Hình Ảnh</th>
                    <th>Số Lượt Xem</th>
                    <th>Nổi Bật</th>
                    <th>Ngày Tạo</th>
                    <th>Ngày Cập Nhật</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->user_id }}</td>
                        <td>{{ $post->categories }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ Str::limit($post->content, 50) }}</td>
                        <td>
                            @if($post->image_url)
                                <img src="{{ asset($post->image_url) }}" alt="Hình ảnh">
                            @else
                                Không có hình ảnh
                            @endif
                        </td>
                        <td>{{ $post->view_count }}</td>
                        <td>{{ $post->is_featured ? 'Có' : 'Không' }}</td>
                        <td>{{ $post->created_at ? $post->created_at->format('d/m/Y H:i') : 'Chưa xác định' }}</td>
                        <td>{{ $post->updated_at ? $post->updated_at->format('d/m/Y H:i') : 'Chưa xác định' }}</td>
                        <td class="action-btns">
                            <a href="{{ url('/managementblog/edit/'.$post->id) }}" class="btn btn-warning">✏️</a>
                            <form action="{{ url('/managementblog/delete/'.$post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $posts->links() }}
        </div>
    </body>

    </html>
@endsection