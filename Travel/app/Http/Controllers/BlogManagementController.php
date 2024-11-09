<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Post::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        }

        $posts = $query->get();
        $categories = Category::all(); // Lấy danh sách danh mục

        return view('admin.blog.blog_index', compact('posts', 'search', 'categories'));
    }



    public function create()
    {
        return view('admin.blog.blog_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|integer',
            'image_url' => 'nullable|url', // Thêm validation cho image_url
            'view_count' => 'nullable|integer',
            'is_featured' => 'boolean',
        ]);

        Post::create($request->all());

        return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được thêm thành công.');
    }

    // BlogManagementController.php

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.blog.blog_edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'categories' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image_url' => 'nullable|string|max:255',
            'view_count' => 'required|integer',
            'is_featured' => 'required|boolean',
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
