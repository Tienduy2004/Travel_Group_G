<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <title>Thêm Tour</title>
</head>
<body>
<form action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="name">Tên tour:</label>
        <input type="text" name="name" id="name" placeholder="Nhập tên tour..." value="{{ old('name') }}">
        @error('name')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="location">Địa điểm:</label>
        <input type="text" name="location" id="location" placeholder="Nhập địa điểm..." value="{{ old('location') }}">
        @error('location')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="time">Thời gian:</label>
        <select name="time" id="time">
            <option value="1 ngày" {{ old('time')=='1 ngày' ? 'selected' : '' }}>1 ngày</option>
            <option value="2 ngày" {{ old('time')=='2 ngày' ? 'selected' : '' }}>2 ngày</option>
            <option value="3 ngày" {{ old('time')=='3 ngày' ? 'selected' : '' }}>3 ngày</option>
            <option value="4 ngày" {{ old('time')=='4 ngày' ? 'selected' : '' }}>4 ngày</option>
            <option value="5 ngày" {{ old('time')=='5 ngày' ? 'selected' : '' }}>5 ngày</option>
            <option value="6 ngày" {{ old('time')=='6 ngày' ? 'selected' : '' }}>6 ngày</option>
        </select>
        @error('time')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="quantity">Số lượng:</label>
        <input type="number" name="quantity" id="quantity" placeholder="Nhập số lượng..." value="{{ old('quantity') }}">
        @error('quantity')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="rating">Đánh Giá:</label>
        <div class="rating" id="rating">
            <span class="star" data-value="1">★</span>
            <span class="star" data-value="2">★</span>
            <span class="star" data-value="3">★</span>
            <span class="star" data-value="4">★</span>
            <span class="star" data-value="5">★</span>
        </div>
        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
        @error('rating')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="price">Giá:</label>
        <input type="number" name="price" id="price" placeholder="Nhập giá tiền..." value="{{ old('price') }}" step="0.01" min="0">
        @error('price')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>


    <div>
        <label for="image">Hình ảnh:</label>
        <input type="file" name="image" id="image" accept="image/png">
        @error('image')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">Lưu</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lắng nghe sự kiện click trên các sao
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                const ratingValue = this.getAttribute('data-value');

                // Cập nhật giá trị của input ẩn
                document.getElementById('rating-input').value = ratingValue;

                // Xóa lớp 'selected' khỏi tất cả sao
                document.querySelectorAll('.star').forEach(s => {
                    s.classList.remove('selected');
                });

                // Thêm lớp 'selected' cho tất cả các sao từ sao đầu đến sao đã chọn
                for (let i = 1; i <= ratingValue; i++) {
                    document.querySelector(`.star[data-value="${i}"]`).classList.add('selected');
                }
            });
        });
    });
</script>
</body>
</html>
