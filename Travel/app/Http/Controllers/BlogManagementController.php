<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Post::with('category');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->paginate(10);

        return view('admin.blog.blog_index', compact('posts', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.blog.blog_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        Post::create($request->all());

        return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được tạo thành công.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.blog.blog_edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được xóa thành công.');
    }
}