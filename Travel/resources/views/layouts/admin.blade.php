<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản trị viên')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <!-- Header, thanh điều hướng -->
        <nav>
            <a href="{{ route('tours.index') }}">Quản lý Tour</a>
            <a href="{{ route('promotions.create') }}">Tạo Khuyến Mãi</a>
            <!-- Các liên kết khác -->
        </nav>
    </header>

    <main>
        @yield('content') <!-- Phần nội dung chính sẽ được chèn ở đây -->
    </main>

    <footer>
        <p>Bản quyền &copy; {{ date('Y') }} Quản trị viên.</p>
    </footer>
</body>
</html>
