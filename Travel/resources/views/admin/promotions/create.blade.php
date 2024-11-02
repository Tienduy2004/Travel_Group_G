<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/promotions_create.css') }}">
    <title>Tạo Khuyến Mãi Mới</title>
   
</head>
<body>
<div class="form-container">
    <h1>Tạo Khuyến Mãi Mới</h1>

    <form action="{{ route('promotions.store') }}" method="POST">
        @csrf
        <div>
            <label for="code">Mã Khuyến Mãi:</label>
            <input type="text" id="code" name="code" required>
        </div>

        <div>
            <label for="description">Mô Tả:</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div>
            <label for="start_date">Ngày Bắt Đầu:</label>
            <input type="date" id="start_date" name="start_date" required>
        </div>

        <div>
            <label for="end_date">Ngày Kết Thúc:</label>
            <input type="date" id="end_date" name="end_date" required>
        </div>

        <div>
            <label for="discount_percentage">Giảm Bao Nhiêu %:</label>
            <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" required>
        </div>

        <button type="submit">Tạo Khuyến Mãi</button>
    </form>
</div>
</body>
</html>
