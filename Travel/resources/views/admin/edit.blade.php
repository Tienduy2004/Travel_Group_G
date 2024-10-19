<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sua.css') }}">
    <title>Sửa admins</title>
</head>

<body>
    <div class="form-container">

        <form action="{{ route('admins.update', $admins->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="name">Tên admins:</label>
                <input type="text" name="name" value="{{ $admins->name }}" placeholder="Tên admins" required>
            </div>

            <div>
                <label for="location">Địa điểm:</label>
                <input type="text" name="location" value="{{ $admins->location }}" placeholder="Địa điểm" required>
            </div>

            <div>
                <label for="time">Thời gian:</label>
                <select name="time" id="time" required>
                    <option value="1 ngày" {{ $admins->time == '1 ngày' ? 'selected' : '' }}>1 ngày</option>
                    <option value="2 ngày" {{ $admins->time == '2 ngày' ? 'selected' : '' }}>2 ngày</option>
                    <option value="3 ngày" {{ $admins->time == '3 ngày' ? 'selected' : '' }}>3 ngày</option>
                    <option value="4 ngày" {{ $admins->time == '4 ngày' ? 'selected' : '' }}>4 ngày</option>
                    <option value="5 ngày" {{ $admins->time == '5 ngày' ? 'selected' : '' }}>5 ngày</option>
                </select>
            </div>

            <div>
                <label for="quantity">Số lượng:</label>
                <input type="number" name="quantity" value="{{ $admins->quantity }}" placeholder="Số lượng" required min="1">
            </div>

            <div>
                <label for="rating">Đánh giá:</label>
                <div class="rating" id="rating">
                    <span class="star {{ $admins->rating >= 1 ? 'selected' : '' }}" data-value="1">★</span>
                    <span class="star {{ $admins->rating >= 2 ? 'selected' : '' }}" data-value="2">★</span>
                    <span class="star {{ $admins->rating >= 3 ? 'selected' : '' }}" data-value="3">★</span>
                    <span class="star {{ $admins->rating >= 4 ? 'selected' : '' }}" data-value="4">★</span>
                    <span class="star {{ $admins->rating >= 5 ? 'selected' : '' }}" data-value="5">★</span>
                </div>
                <input type="hidden" name="rating" id="rating-input" value="{{ $admins->rating }}">
                @error('rating')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="price">Giá tiền:</label>
                <input type="number" name="price" value="{{ $admins->price }}" placeholder="Giá tiền" required min="1">
            </div>


            <div>
                <label for="image">Hình ảnh:</label>
                <input type="file" name="image" accept="image/*">
                @if($admins->image)
                <div>
                    <p>Hình ảnh hiện tại:</p>
                    <img src="{{ asset('images/' . $admins->image) }}" alt="Hình ảnh hiện tại" width="150">
                </div>
                @endif
            </div>

            <button type="submit">Cập nhật</button>
        </form>
    </div>

    <script>
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
    </script>
</body>

</html>
