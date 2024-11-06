<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sua.css') }}">
    <title>Sửa Tour</title>
</head>

<body>
    <div class="form-container">
        <h1>Sửa Tour</h1>

        <form action="{{ route('tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="name">Tên tour:</label>
                <input type="text" name="name" value="{{ $tour->name }}" placeholder="Tên tour" required>
            </div>

            <div>
                <label for="id_destination">Địa điểm:</label>
                <select name="id_destination" required>
                    <option value="">-- Chọn địa điểm --</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination->id }}" {{ $tour->id_destination == $destination->id ? 'selected' : '' }}>
                            {{ $destination->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="description">Mô tả:</label>
                <textarea name="description" placeholder="Mô tả" required>{{ $tour->description }}</textarea>
            </div>

            <div>
                <label for="price">Giá tiền:</label>
                <input type="number" name="price" value="{{ $tour->price }}" placeholder="Giá tiền" required min="0" step="0.01">
            </div>

            <div>
                <label for="number_days">Số ngày:</label>
                <input type="number" name="number_days" value="{{ $tour->number_days }}" placeholder="Số ngày" required min="1">
            </div>
            <div>
                <label for="program_code">Mã chương trình:</label>
                <input type="text" name="program_code" value="{{ $tour->program_code }}" placeholder="Mã chương trình">
            </div>

            <div>
                <label for="is_active">Trạng thái hoạt động:</label>
                <select name="is_active" required>
                    <option value="1" {{ $tour->is_active == 1 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ $tour->is_active == 0 ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>

            <div>
                <label for="id_departure_location">Địa điểm khởi hành:</label>
                <select name="id_departure_location" required>
                    <option value="">-- Chọn địa điểm khởi hành --</option>
                    @foreach($departureLocations as $departureLocation)
                        <option value="{{ $departureLocation->id }}" {{ $tour->id_departure_location == $departureLocation->id ? 'selected' : '' }}>
                            {{ $departureLocation->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="person">Số người:</label>
                <input type="number" name="person" value="{{ $tour->person }}" placeholder="Số người" required min="1">
            </div>

            <div>
                <label for="image_main">Hình ảnh:</label>
                <input type="file" name="image_main" accept="image/*">
                @if($tour->image_main)
                <div>
                    <p>Hình ảnh hiện tại:</p>
                    <img src="{{ asset('img/tours/' . $tour->image_main) }}" alt="Hình ảnh hiện tại" width="150">
                </div>
                @endif
            </div>

            <button type="submit">Cập nhật</button>
        </form>
    </div>
</body>

</html>
