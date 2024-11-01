<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Lấy giá trị tìm kiếm từ request

        $query = Post::query();

        // Thêm điều kiện tìm kiếm nếu có từ khóa
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        $posts = $query->paginate(5); // Phân trang 5 bài viết trên mỗi trang

        return view('admin.blog.blog_index', compact('posts', 'search'));
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

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.blog.blog_edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|integer',
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
