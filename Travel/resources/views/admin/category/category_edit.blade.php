@extends('layouts.menu')

@section('content')
    <h1 class="text-center" style="color: #333; text-align: center; margin-top: 20px;">Sửa Danh Mục</h1>

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

    <form action="{{ route('admin.category.update', $category->id) }}" method="POST" style="max-width: 500px; margin: 0 auto;">
        @csrf
        @method('PUT')

        <!-- Tên Danh Mục -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="name" style="font-weight: bold; color: #333;">Tên Danh Mục</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" placeholder="Nhập tên danh mục..." required>
        </div>

        <!-- Nút Cập Nhật -->
        <button type="submit" class="btn btn-warning" style="font-size: 16px; padding: 10px 20px; border-radius: 8px; background-color: #ffc107; color: white; width: 100%;">Cập Nhật</button>
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
    </style>
@endsection
