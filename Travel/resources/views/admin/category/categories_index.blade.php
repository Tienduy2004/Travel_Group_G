@extends('layouts.menu')

@section('content')
    <h1 class="text-center" style="color: #333;">Quản Lý Danh Mục</h1>

    <!-- Hiển thị thông báo thành công -->
    @if(session('success'))
        <div class="alert alert-success" style="padding: 10px; background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Thanh công cụ với form tìm kiếm -->
    <div class="toolbar" style="display: flex; justify-content: space-between; margin-bottom: 15px; padding: 0 20px;">
        <div class="search-box">
            <form action="{{ route('admin.category.index') }}" method="GET" style="display: flex; align-items: center; gap: 10px;">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="🔍 Tìm kiếm danh mục..." style="padding: 10px 15px; font-size: 16px; border: 1px solid #ccc; border-radius: 8px; max-width: 350px; width: 100%;">
                <button type="submit" style="padding: 10px 20px; font-size: 16px; font-weight: bold; color: white; background-color: #28a745; border: none; border-radius: 8px; cursor: pointer; transition: background-color 0.3s ease;">Tìm kiếm</button>
            </form>
        </div>
        <!-- Nút thêm danh mục -->
        <a href="{{ route('admin.category.create') }}" class="btn btn-primary" style="font-size: 16px; padding: 10px 20px; border-radius: 8px; background-color: #007bff; color: white;">Thêm Danh Mục Mới</a>
    </div>

    <!-- Bảng danh mục -->
    <div class="table-responsive">
        <table class="table" style="width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 18px; text-align: left; background-color: #ffffff; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); border-radius: 8px;">
            <thead style="background-color: #f8f9fa; color: #333;">
                <tr>
                    <th>ID</th>
                    <th>Tên Danh Mục</th>
                    <th>Ngày Tạo</th>
                    <th>Ngày Cập Nhật</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr style="border-bottom: 1px solid #f1f1f1;">
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>  
                        <td>{{ $category->created_at ? $category->created_at->format('d/m/Y H:i') : 'Chưa xác định' }}</td>
                        <td>{{ $category->updated_at ? $category->updated_at->format('d/m/Y H:i') : 'Chưa xác định' }}</td>
                        <td style="display: flex; gap: 10px;">
                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-warning" style="color: #ffc107;">✏️</a>
                            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="color: red;" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    

    <style>
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .table th, .table td {
            vertical-align: middle;
            padding: 15px;
        }

        .table-responsive {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Căn chỉnh phân trang */
        .pagination-container .pagination {
            display: flex;
            gap: 5px;
            list-style: none;
            padding: 0;
        }

        .pagination-container .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%; 
            width: 40px;
            height: 40px;
            font-weight: bold;
            color: #333;
            border: none;
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        .pagination-container .page-item.active .page-link {
            background-color: #28a745;
            color: white;
        }

        .pagination-container .page-item .page-link:hover {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
@endsection
