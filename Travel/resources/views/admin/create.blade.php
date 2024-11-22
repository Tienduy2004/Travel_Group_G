<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <title>Thêm Tour</title>
</head>

<body>
    <form action="{{ route('tours.store') }}" method="POST" enctype="multipart/form-data">
        <h1>Thêm Tour</h1>
        @csrf
        <div>
            <label for="name">Tên tour:</label>
            <input type="text" name="name" id="name" placeholder="Nhập tên tour..." value="{{ old('name') }}"
                oninput="generateSlug()">
            @error('name')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="slug">Slug:</label>
            <input type="text" name="slug" id="slug" placeholder="Nhập slug..." value="{{ old('slug') }}" readonly>
            @error('slug')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <script>
            function generateSlug() {
                const name = document.getElementById("name").value;
                let slug = name.toLowerCase()
                    .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                    .replace(/đ/g, "d")
                    .replace(/[^a-z0-9\s-]/g, "")
                    .trim()
                    .replace(/\s+/g, "-");
                document.getElementById("slug").value = slug;
            }
        </script>
        <div>
            <label for="id_destination">Địa điểm:</label>
            <select name="id_destination" id="id_destination">
                <option value="">-- Chọn địa điểm --</option>
                @foreach($destinations as $destination)
                <option value="{{ $destination->id }}" {{ old('id_destination')==$destination->id ? 'selected' : '' }}>
                    {{ $destination->name }}
                </option>
                @endforeach
            </select>
            @error('id_destination')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">Mô tả:</label>
            <textarea name="description" id="description"
                placeholder="Nhập mô tả...">{{ old('description') }}</textarea>
            @error('description')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="price">Giá:</label>
            <input type="number" name="price" id="price" placeholder="Nhập giá tiền..." value="{{ old('price') }}"
                step="0.01" min="0">
            @error('price')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="price_single_room">Giá phòng đơn:</label>
            <input type="number" name="price_single_room" id="price_single_room" placeholder="Nhập giá phòng đơn..."
                value="{{ old('price_single_room') }}" step="0.01" min="0">
            @error('price_single_room')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="number_days">Số ngày:</label>
            <input type="number" name="number_days" id="number_days" placeholder="Nhập số ngày..."
                value="{{ old('number_days') }}" min="1">
            @error('number_days')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="is_active">Trạng thái hoạt động:</label>
            <select name="is_active" id="is_active">
                <option value="1" {{ old('is_active')=='0' ? 'selected' : '' }}>Chọn trạng thái hoạt động</option>
                <option value="1" {{ old('is_active')=='1' ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('is_active')=='2' ? 'selected' : '' }}>Không hoạt động</option>
            </select>
            @error('is_active')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="id_departure_location">Địa điểm khởi hành:</label>
            <select name="id_departure_location" id="id_departure_location">
                <option value="">-- Chọn địa điểm khởi hành --</option>
                @foreach($departureLocations as $departureLocation)
                <option value="{{ $departureLocation->id }}" {{ old('id_departure_location')==$departureLocation->id ?
                    'selected' : '' }}>
                    {{ $departureLocation->name }}
                </option>
                @endforeach
            </select>
            @error('id_departure_location')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="person">Số người:</label>
            <input type="number" name="person" id="person" placeholder="Nhập số người..." value="{{ old('person') }}"
                min="1">
            @error('person')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="image_main">Hình ảnh:</label>
            <input type="file" name="image_main" id="image_main" accept="image/png,image/jpg,image/jpeg">
            @error('image_main')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Lưu</button>
    </form>

</body>

</html>