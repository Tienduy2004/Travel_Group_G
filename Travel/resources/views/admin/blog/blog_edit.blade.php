@extends('layouts.menu')

@section('content')
    <h1>Quản Lý Bài Viết</h1>

    <div class="toolbar">
        <div class="search-box">
            <form action="{{ route('admin.blog.index') }}" method="GET" style="display: flex; align-items: center; gap: 10px;">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="🔍 Tìm kiếm bài viết..." style="padding: 10px 15px; font-size: 16px; border: 1px solid #ccc; border-radius: 8px; width: 100%; max-width: 350px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                <button type="submit" style="padding: 10px 20px; font-size: 16px; font-weight: bold; color: white; background-color: #28a745; border: none; border-radius: 8px; cursor: pointer; transition: background-color 0.3s ease;">
                    Tìm kiếm
                </button>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Nội Dung</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ Str::limit($post->content, 50) }}</td>
                    <td class="action-btns">
                        <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-warning">✏️</a>
                        <form action="{{ route('admin.blog.delete', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $posts->links() }}
    </div>
@endsection
