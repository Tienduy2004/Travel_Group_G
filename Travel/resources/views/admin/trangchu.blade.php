<!-- resources/views/admin/trangchu.blade.php -->
@extends('layouts.menu')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/ql_tour.css') }}">
    <title>Quản Lý Tour</title>
</head>

<body>
    <h1>Quản Lý Tour</h1>
    <div class="form-container">
        <form action="{{ route('tours.search') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Nhập tên tour để tìm kiếm..." required>
            <button type="submit">Tìm kiếm</button>
        </form>

        <form action="{{ route('tours.create') }}" method="GET" class="create-form">
            <button type="submit">Thêm</button>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên tour</th>
                <th>Địa điểm</th>
                <th>Số ngày</th>
                <th>Số người</th>
                <th>Giá Gốc</th>
                <th>Giá Giảm</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tours as $index => $tour)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $tour->name }}</td>
                <td>{{ $tour->destination->name ?? 'Chưa có' }}</td> <!-- Assuming destination is a relation -->
                <td>{{ $tour->number_days }}</td>
                <td>{{ $tour->person }}</td>
                <td>{{ number_format($tour->price, 0, ',', '.') }} VND</td>
                <td>{{ number_format($tour->discount_price, 0, ',', '.') }} VND</td>
                <td><img src="{{ asset('img/tours/' . $tour->image_main) }}" alt="Image" width="50" height="50"></td>
                <td>
                    <a href="{{ route('tours.edit', $tour->id) }}">✏️</a>
                    <form action="{{ route('tours.destroy', $tour->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="pagination">
        {{ $tours->links() }} 
    </div>

</body>

</html>
@endsection