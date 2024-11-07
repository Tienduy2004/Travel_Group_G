@extends('layouts.menu')

@section('content')
    <h1 style="text-align: center; color: #333;">Quản Lý Danh Mục</h1>

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
    </div>

    <!-- Bảng danh mục -->
    <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 18px; text-align: left; background-color: #ffffff;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Danh Mục</th>
                <th>Mô Tả</th>
                <th>Ngày Tạo</th>
                <th>Ngày Cập Nhật</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ Str::limit($category->description, 50) }}</td>
                    <td>{{ $category->created_at ? $category->created_at->format('d/m/Y H:i') : 'Chưa xác định' }}</td>
                    <td>{{ $category->updated_at ? $category->updated_at->format('d/m/Y H:i') : 'Chưa xác định' }}</td>
                    <td class="action-btns" style="display: flex; gap: 10px;">
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

    <!-- Phân trang -->
    <div class="pagination" style="display: flex; justify-content: center; margin-top: 20px; list-style: none;">
        {{ $categories->appends(['search' => $search])->links() }}
    </div>
@endsection
