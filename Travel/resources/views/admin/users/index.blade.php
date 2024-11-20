@extends('layouts.menu')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/phanquyen.css') }}">
</head>
<body>
<h1>Danh sách người dùng</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên người dùng</th>
            <th>Email</th>
            <th>Vai trò</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->role }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $admin->id) }}" class="btn btn-warning">Chỉnh sửa quyền</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $admins->links() }} <!-- Phân trang -->
    
</body>
</html>
   
@endsection
