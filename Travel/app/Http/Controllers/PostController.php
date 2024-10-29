<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    //hien thi trang blog
    public function index()
    {
        $categories = Post::getCategorywithPostCount();
        $posts = Post::getPost();
        $totalPost = Post::totalPostCount();

        return view('home.page.blog', data: compact('posts', 'categories', 'totalPost'));
    }
    //hien thi bai viet chi tiet
    public function showBlog($blogId)
    {
        $blog = Post::getTotalPost($blogId);

        if (!$blog) {
            return abort(404);
        }

        $categories = Post::getCategorywithPostCount();
        $totalPost = Post::totalPostCount();

        return view('home.page.single', compact('blog', 'categories', 'totalPost'));
    }
    //Lay bai viet theo danh muc
    public function getPostbyCategory($categoryId)
    {
        $posts = Post::getPostWithCategory($categoryId);

        if (!$posts) {
            return abort(404);
        }

        $categories = Post::getCategorywithPostCount();
        $totalPost = Post::totalPostCount();

        return view('home.page.blog', compact('posts', 'categories', 'totalPost'));
    }
    // Tim kiem
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return back()->withInput()->with('error', 'Please enter keywords to search!');
        }
        if (strlen($query) > 100) {
            return back()->withInput()->with('error', 'Keyword cannot be longer than 100 characters!');
        }

        $posts = Post::searchPosts($query)->paginate(6);
        $categories = Post::getCategorywithPostCount();
        $totalPost = Post::totalPostCount();

        return view('home.page.blog', compact('posts', 'categories', 'totalPost'))->with('query', $query);
    }
    //hien thi form tao bai viet
    public function create_post()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to log in to create a post.');
        }

        $categories = Category::all();
        $user = Auth::user();

        return view('home.page.create_post', compact('categories', 'user'));
    }
    //gui bai viet ve admin
    public function storePost(Request $request)
    {
        // Xác thực dữ liệu
        $validateData = $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
            'content' => 'required',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        // Xử lý ảnh nếu có
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');

            // Kiểm tra kích thước file (không quá 5MB)
            if ($file->getSize() > 5120 * 1024) {
                return back()->withErrors(['image_url' => 'Image size exceeds the 5MB limit.']);
            }
            // Xử lý lưu ảnh và kiểm tra quyền ghi
            try {
                $imageName = time() . '.' . $request->image_url->extension();
                $request->image_url->move(public_path('img/blog'), $imageName);
                $validateData['image_url'] = 'blog/' . $imageName;
            } catch (\Exception $e) {
                Log::error('Failed to upload image: ' . $e->getMessage());
                return back()->withErrors(['image_url' => 'There was an error uploading the image.']);
            }
        }

        // Lưu bài viết vào CSDL
        Post::storePost($validateData);

        return redirect()->route('blog')->with('success', 'Your post has been submitted and is pending approval');
    }

}
