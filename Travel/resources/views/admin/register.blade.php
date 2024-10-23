<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký Admin</title>
</head>
<body>
    <h2>Đăng ký tài khoản Admin</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('admin.register.submit') }}">
        @csrf
        <label for="name">Tên:</label>
        <input type="text" name="name" required value="{{ old('name') }}">

        <label for="email">Email:</label>
        <input type="email" name="email" required value="{{ old('email') }}">

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required>

        <label for="password_confirmation">Xác nhận mật khẩu:</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Đăng ký</button>
    </form>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p style="color: red;">{{ $error }}</p>
            @endforeach
        </div>
    @endif
</body>
</html>
