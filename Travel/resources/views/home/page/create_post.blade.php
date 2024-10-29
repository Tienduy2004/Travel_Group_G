@extends('layouts.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<div class="container mx-auto p-10 mt-10 bg-white rounded-lg shadow-md max-w-6xl">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">Write News Post</h1>

    <div class="flex items-center space-x-4 mb-4">
        <img src="https://via.placeholder.com/50" alt="User Avatar" class="w-12 h-12 rounded-full">
        <span class="text-lg font-semibold">{{ $user->name }}</span>
    </div>

    <form action="{{ route('store.post') }}" method="POST" id="blogForm" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium">Title</label>
            <input type="text" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" id="title" name="title" required placeholder="Enter the title of your post">
        </div>

        <div class="mb-4">
            <label for="category" class="block text-gray-700 font-medium">Category</label>
            <select class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" id="category" name="category_id" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="featuredImage" class="block text-gray-700 font-medium">Featured Image</label>
            <input type="file" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" id="featuredImage" name="image_url" accept="image/*">
        </div>

        <div id="imagePreview" class="mt-2 mb-2"></div>

        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-medium">Content</label>
            <textarea id="content" name="content" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" rows="5" placeholder="Write your content here..."></textarea>
        </div>

        <button type="submit" class="w-full py-3 mt-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-200">Publish Post</button>
    </form>
</div>

@endsection