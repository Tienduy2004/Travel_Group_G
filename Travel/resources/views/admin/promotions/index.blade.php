<!-- resources/views/admin/trangchu.blade.php -->
@extends('layouts.menu')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        }

        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            border: 1px solid #007bff;
            color: #007bff;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #ffffff;
        }

        .pagination a:hover {
            background-color: #0056b3;
            color: white;
        }

        button.btn-danger img {
            width: 24px;
            height: auto;
        }



        .pagination {
            display: flex;
            justify-content: center;
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

        .pagination li a,
        .pagination li span {
            line-height: 1.5;
        }

        .pagination li:first-child a,
        .pagination li:first-child span,
        .pagination li:last-child a,
        .pagination li:last-child span {
            padding: 6px 9px;
            /* Điều chỉnh mũi tên đầu và cuối */
        }

        .pagination .disabled a {
            pointer-events: none;
        }

        .pagination-summary,
        .pagination-text {
            display: none !important;
        }
        form.search-form input[type="text"] {
    padding: 10px;
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

form.search-form button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form.search-form button:hover {
    background-color: #0056b3;
}

/* Định dạng cho form thêm tour */
form.create-form button {
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form.create-form button:hover {
    background-color: #218838;
}
    </style>
</head>

<body>

    <h1>Quản Lý Chương Trình Khuyến Mãi</h1>

    <!-- Toolbar gồm thanh tìm kiếm bên trái và nút thêm khuyến mãi bên phải -->
    <div class="toolbar">
        <form action="{{ route('promotions.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Nhập mã hoặc mô tả để tìm kiếm..." value="{{ old('search', $search) }}">
            <button type="submit">Tìm kiếm</button>
        </form>
        <a href="{{ route('promotions.create') }}" class="btn btn-primary">Thêm Khuyến Mãi</a>
    </div>

    <!-- Hiển thị thông báo nếu có -->
    @if(isset($message))
        <div class="alert alert-info">
            {{ $message }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã Khuyến Mãi</th>
                <th>Mô Tả</th>
                <th>Ngày Bắt Đầu</th>
                <th>Ngày Kết Thúc</th>
                <th>Giá Trị Giảm Giá</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promotions as $promotion)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $promotion->code }}</td>
                <td>{{ $promotion->description }}</td>
                <td>{{ \Carbon\Carbon::parse($promotion->start_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($promotion->end_date)->format('d/m/Y') }}</td>
                <td>{{ $promotion->discount_percentage }}%</td>
                <td class="action-btns">
                    <!-- Nút Sửa -->
                    <a href="{{ route('promotions.edit', $promotion->id) }}" class="btn btn-warning">✏️</a>

                    <!-- Nút Xóa -->
                    <form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="pagination">
        {{ $promotions->links() }}
    </div>

</body>


</html>
@endsection