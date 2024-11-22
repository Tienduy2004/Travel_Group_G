<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class BlogManagementController extends Controller
{
    // Hiển thị danh sách bài viết
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Post::with('category');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->paginate(10); // Phân trang 10 bài viết

        return view('admin.blog.blog_index', compact('posts', 'search'));
    }

    // Hiển thị form tạo bài viết
    public function create()
    {
        $categories = Category::all();
        return view('admin.blog.blog_create', compact('categories'));
    }

    // Lưu bài viết mới
    public function store(Request $request)
    {
        try {
            // Xác thực dữ liệu đầu vào
            $request->validate([
                'title' => 'required|unique:posts,title', // Kiểm tra tiêu đề không trùng lặp
                'content' => 'required',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Xử lý hình ảnh nếu có
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public'); // Lưu vào thư mục public/images
            }

            // Tạo bài viết mới
            Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'user_id' => 'admin', // Gán mặc định user_id là admin
                'image' => $imagePath, // Lưu đường dẫn hình ảnh
            ]);

            return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được tạo thành công.');

        } catch (QueryException $e) {
            // Ghi lại lỗi vào log
            Log::error('Error storing post: ' . $e->getMessage());

            // Thông báo lỗi cho người dùng
            return redirect()->route('admin.blog.index')->with('error', 'Đã có lỗi xảy ra, vui lòng kiểm tra lại dữ liệu.');
        }
    }

    // Hiển thị form chỉnh sửa bài viết
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.blog.blog_edit', compact('post', 'categories'));
    }

    // Cập nhật bài viết
    public function update(Request $request, $id)
    {
        try {
            // Xác thực dữ liệu đầu vào
            $request->validate([
                'title' => 'required|unique:posts,title,' . $id, // Kiểm tra tiêu đề không trùng lặp (trừ bài viết hiện tại)
                'content' => 'required',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            // Lấy bài viết để cập nhật
            $post = Post::findOrFail($id);
    
            // Xử lý hình ảnh nếu có thay đổi
            if ($request->hasFile('image')) {
                // Xóa hình cũ nếu có
                if ($post->image) {
                    \Storage::delete('public/' . $post->image);
                }
    
                // Lưu hình ảnh mới
                $imagePath = $request->file('image')->store('images', 'public');
                $post->image = $imagePath;
            }

            // Cập nhật các trường bài viết nếu có thay đổi
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->category_id = $request->input('category_id');
    
            $post->save(); // Lưu bài viết
    
            // Thông báo và quay lại trang danh sách bài viết
            return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được cập nhật thành công.');
    
        } catch (QueryException $e) {
            // Ghi lại lỗi vào log
            Log::error('Error updating post: ' . $e->getMessage());
    
            // Thông báo lỗi cho người dùng
            return redirect()->route('admin.blog.index')->with('error', 'Đã có lỗi xảy ra, vui lòng kiểm tra lại dữ liệu.');
        }
    }

    // Xóa bài viết
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            // Xóa hình ảnh nếu có
            if ($post->image) {
                \Storage::delete('public/' . $post->image);
            }

            $post->delete();

            return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được xóa thành công.');

        } catch (QueryException $e) {
            // Ghi lại lỗi vào log
            Log::error('Error deleting post: ' . $e->getMessage());

            // Thông báo lỗi cho người dùng
            return redirect()->route('admin.blog.index')->with('error', 'Đã có lỗi xảy ra khi xóa bài viết.');
        }
    }
}
