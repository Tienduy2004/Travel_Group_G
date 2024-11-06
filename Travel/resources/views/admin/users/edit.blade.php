@extends('layouts.menu')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân Quyền</title>
    <link rel="stylesheet" href="{{ asset('css/edit_phanquyen.css') }}">
</head>
<body>
    
<h1>Chỉnh sửa quyền người dùng</h1>

<form action="{{ route('admin.users.update', $admin->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="role">Chọn vai trò</label>
        <select name="role" id="role" class="form-control">
            <option value="admin" {{ $admin->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="customer" {{ $admin->role == 'customer' ? 'selected' : '' }}>Customer</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật quyền</button>
</form>

<a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</body>
</html>

@endsection
