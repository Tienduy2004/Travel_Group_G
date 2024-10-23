<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập Admin</title>
</head>
<body>
    <h2>Đăng nhập vào trang quản lý</h2>

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Đăng nhập</button>
    </form>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</body>
</html>
