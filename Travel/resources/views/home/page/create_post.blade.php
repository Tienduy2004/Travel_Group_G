@extends('layouts.app')
@section('content')
<style>
    .user-info {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 15px;
    }
</style>

<div class="container mt-5">
    <h1 class="mb-4">Create a New Blog Post</h1>
    <div class="user-info">
        <img src="" alt="User Avatar" class="user-avatar">
        <h5 class="mb-0">John Doe</h5>
    </div>
    <form>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" required>
                <option value="">Choose a category</option>
                <option value="technology">Technology</option>
                <option value="lifestyle">Lifestyle</option>
                <option value="travel">Travel</option>
                <option value="food">Food</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" required>
        </div>
        <div class="mb-3">
            <label for="featuredImage" class="form-label">Featured Image</label>
            <input type="file" class="form-control" id="featuredImage" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea id="content" name="content"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Publish Post</button>
    </form>
</div>

@endsection