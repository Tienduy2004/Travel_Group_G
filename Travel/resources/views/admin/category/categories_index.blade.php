@extends('layouts.menu')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Danh Mục</title>
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
            align-items: center;
            margin-bottom: 15px;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #fff;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .search-box input[type="text"] {
            padding: 8px;
            font-size: 14px;
            width: 200px;
            border: none;
            outline: none;
            border-radius: 4px;
        }

        .search-box button {
            padding: 8px 12px;
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
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        a.btn-primary:hover {
            background-color: #0056b3;
        }

        /* Bảng hiển thị */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
            background-color: #ffffff;
        }

        th, td {
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
        .pagination {
    display: flex;
    justify-content: center; /* Căn giữa các nút phân trang */
    align-items: center;
    margin-top: 20px;
}

.pagination .page-item {
    margin: 0 5px; /* Tạo khoảng cách đều giữa các nút */
}

.pagination .page-link {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px; /* Bo góc nút */
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.pagination .page-link:hover,
.pagination .page-item.active .page-link {
    background-color: #0056b3;
    transform: translateY(-2px); /* Hiệu ứng di chuyển nút lên khi hover */
}

.pagination .page-item.disabled .page-link {
    background-color: #e0e0e0;
    color: #9e9e9e;
    cursor: not-allowed;
}

.pagination .page-item .page-link {
    border: 1px solid #007bff; /* Thêm đường viền cho nút */
}

.pagination .page-link:focus {
    outline: none;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
}

    </style>
</head>

<body>

    <h1>Quản Lý Danh Mục</h1>

    <!-- Toolbar gồm thanh tìm kiếm và nút thêm danh mục -->
    <div class="toolbar">
        <!-- Form tìm kiếm -->
        <div class="search-box">
            <form action="{{ route('admin.category.index') }}" method="GET" style="display: flex; align-items: center;">
                <input type="text" name="search" placeholder="Tìm kiếm danh mục..." value="{{ $search }}">
                <button type="submit">Tìm</button>
            </form>
        </div>

        <!-- Nút thêm danh mục -->
        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Thêm Danh Mục Mới</a>
    </div>

    <!-- Bảng hiển thị thông tin danh mục -->
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên Danh Mục</th>
                <th>Ngày Tạo</th>
                <th>Ngày Cập Nhật</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->created_at ? $category->created_at->format('d/m/Y') : 'Chưa xác định' }}</td>
                <td>{{ $category->updated_at ? $category->updated_at->format('d/m/Y') : 'Chưa xác định' }}</td>
                <td class="action-btns">
                    <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-warning">✏️</a>
                    <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display: inline;">
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
        {{ $categories->links() }}
    </div>

</body>

</html>
@endsection
