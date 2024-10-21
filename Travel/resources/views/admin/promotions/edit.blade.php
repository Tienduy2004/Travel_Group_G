<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/promotions_edit.css') }}">
    <title>Document</title>
</head>
<body>
<style>
    body {
        background-color: #f8f9fa; /* Màu nền nhẹ nhàng */
    }
    .container {
        margin-top: 30px; /* Khoảng cách từ trên xuống */
        padding: 20px;
        border-radius: 5px;
        background-color: white; /* Nền trắng cho form */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ cho form */
    }
    h1 {
        margin-bottom: 20px; /* Khoảng cách dưới tiêu đề */
    }
    .btn {
        margin-top: 10px; /* Khoảng cách giữa các nút */
    }
</style>
<div class="container">
    <h1>Chỉnh sửa Khuyến Mãi</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('promotions.update', $promotion->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Thêm phương thức PUT cho cập nhật -->

        <div class="form-group">
            <label for="code">Mã Khuyến Mãi</label>
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $promotion->code) }}" required>
            @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Mô Tả</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $promotion->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="start_date">Ngày Bắt Đầu</label>
            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $promotion->start_date) }}" required>
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="end_date">Ngày Kết Thúc</label>
            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $promotion->end_date) }}" required>
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="discount_percentage">Tỷ Lệ Giảm Giá (%)</label>
            <input type="number" class="form-control @error('discount_percentage') is-invalid @enderror" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage', $promotion->discount_percentage) }}" required min="0" max="100">
            @error('discount_percentage')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        
    
    </form>
</div>
</body>
</html>



