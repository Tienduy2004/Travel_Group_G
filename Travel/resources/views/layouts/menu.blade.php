<!-- resources/views/layouts/menu.blade.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            /* Để chứa menu và nội dung theo chiều dọc */
        }

        .menu {
            background-color: #007700;
            /* Màu nền menu */
            padding: 20px;
            /* Padding cho menu */
            width: 200px;
            /* Độ rộng của menu */
            height: 100vh;
            /* Chiều cao menu 100% màn hình */
            display: flex;
            /* Sử dụng flexbox để sắp xếp các mục menu */
            flex-direction: column;
            /* Sắp xếp các mục menu theo chiều dọc */
            align-items: flex-start;
            /* Căn trái các mục menu */
            box-shadow: 5px 0 10px rgba(0, 0, 0, 0.2);
            /* Đổ bóng cho menu */
        }

        .menu a {
            margin: 10px 0;
            /* Khoảng cách giữa các mục menu */
            text-decoration: none;
            color: #ffffff;
            /* Màu chữ trắng */
            padding: 10px 6px;
            /* Padding cho các mục menu */
            border-radius: 5px;
            /* Bo tròn góc */
            transition: background-color .7s, box-shadow 0.5s;
            /* Hiệu ứng chuyển màu nền và bóng khi hover */
            display: flex;
            /* Sử dụng flexbox cho các mục menu */
            align-items: center;
            /* Căn giữa biểu tượng và chữ */
            width: 100%;
            /* Đảm bảo các mục menu có chiều rộng 100% */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Bóng nhẹ cho mục menu */
        }

        .menu a i {
            margin-right: 5px;
            /* Khoảng cách giữa biểu tượng và chữ */
        }

        .menu a:hover {
            background-color: #FF0000;
            /* Màu nền khi hover */
            text-decoration: none;
            /* Bỏ gạch chân khi hover */
            width: 190px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            /* Bóng đậm hơn khi hover */
        }

        .content {
            padding: 20px;
            /* Padding cho nội dung */
            flex-grow: 1;
            /* Để nội dung chiếm không gian còn lại */
        }

        .circle-container {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 50%;
            /* Biến khung chứa thành hình tròn */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Bóng nhẹ cho hình tròn */
        }

        .circle-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Đảm bảo hình ảnh vừa khung tròn mà không bị biến dạng */
        }

        h3 {
            padding-left: 20px;
            color: #ffffff;
            font-size: 30px;
        }
    </style>
</head>

<body>
    <div class="menu">
        <h3>TRAVELER</h3>
        <div class="circle-container">
            <img src="{{ asset('img/tours/logo.jpg') }}" alt="Logo">
        </div>
        <a href="{{ route('admin.trangchu') }}"><i class="fas fa-home"></i>Quản Lý Tour</a>
        <a href="{{ route('promotions.index') }}"><i class="fas fa-tags"></i>Quản Lý Khuyến Mãi</a>
        <!-- Thêm các mục menu khác tại đây -->
    </div>

    <div class="content">
        @yield('content')
    </div>
</body>

</html>