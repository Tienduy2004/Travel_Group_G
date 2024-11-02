<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Menu mặc định ẩn */
        .menu {
            width: 180px;
            background-color: #007700;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -220px;
            /* Ẩn menu bên ngoài */
            transition: 0.5s;
        }

        .menu.open {
            left: 0;
            /* Menu trượt vào */
        }

        /* CSS cho biểu tượng 3 gạch */
        .hamburger {
            display: block;
            cursor: pointer;
            padding: 15px;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1000;
            transition: opacity 0.5s ease;
        }

        /* Ẩn hamburger khi menu mở */
        .hamburger.hide {
            opacity: 0;
            pointer-events: none;
            /* Vô hiệu hóa click khi hamburger ẩn */
        }

        .hamburger .bar {
            width: 35px;
            height: 5px;
            background-color: #fff;
            margin: 6px 0;
            transition: 0.4s;
        }

        .menu a {
            margin: 10px 0;
            text-decoration: none;
            color: #ffffff;
            padding: 10px 6px;
            border-radius: 5px;
            transition: background-color 0.7s, box-shadow 0.5s;
            display: flex;
            align-items: center;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .menu a:hover {
            background-color: #FF0000;
        }

        /* Khi menu được mở */
        .menu.open {
            left: 0;
        }

        .circle-container {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .circle-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hamburger img {
            width: 38px;
            height: 38px;
            margin-top: -10px;
            margin-left: -10px;
        }

        #logout-form {
            position: absolute;
            bottom: 50px;
            left: 20px;
        }

        .btn-danger {
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #FF0000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #cc0000;
        }
    </style>
</head>

<body>
    <div class="hamburger" id="hamburger" onclick="toggleMenu()">
        <img src="{{ asset('img/tours/icons8-menu-48.png') }}" alt="Logo">
    </div>

    <div class="menu" id="side-menu">
        <h3>TRAVELER</h3>
        <h2>{{ session('admin_name') }}</h2>
        <div class="circle-container">
            <img src="{{ asset('img/tours/logo.jpg') }}" alt="Logo">
        </div>
        <a href="{{ route('admin.trangchu') }}"><i class="fas fa-home"></i>Quản Lý Tour</a>
        <a href="{{ route('promotions.index') }}"><i class="fas fa-tags"></i>Quản Lý Khuyến Mãi</a>

        <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="submit" class="btn btn-danger">Đăng Xuất</button>
        </form>
    </div>
    <script>
        function toggleMenu() {
            var menu = document.getElementById('side-menu');
            var hamburger = document.getElementById('hamburger');
            menu.classList.toggle('open');
            hamburger.classList.toggle('hide'); // Ẩn/hiện hamburger khi menu mở/đóng
        }

        // Ẩn menu khi cuộn trang
        window.addEventListener('scroll', function () {
            var menu = document.getElementById('side-menu');
            var hamburger = document.getElementById('hamburger');
            if (menu.classList.contains('open')) {
                menu.classList.remove('open');
                hamburger.classList.remove('hide');
            }
        });

        // Đóng menu khi nhấn ra ngoài
        document.addEventListener('click', function (event) {
            var menu = document.getElementById('side-menu');
            var hamburger = document.getElementById('hamburger');
            var isClickInsideMenu = menu.contains(event.target);
            var isClickInsideHamburger = hamburger.contains(event.target);

            if (!isClickInsideMenu && !isClickInsideHamburger && menu.classList.contains('open')) {
                menu.classList.remove('open');
                hamburger.classList.remove('hide'); // Hiện lại hamburger khi menu đóng
            }
        });
    </script>

    <div class="content">
        @yield('content')
    </div>
</body>

</html>