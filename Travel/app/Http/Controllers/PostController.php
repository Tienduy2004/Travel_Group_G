<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
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
        $topViewPosts = Post::topViewPosts();

        return view('home.page.blog', data: compact('posts', 'categories', 'totalPost', 'topViewPosts'));
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
        $blog->increment('view_count');
        $topViewPosts = Post::topViewPosts();
        $comments = $blog->commentsFirst()->get();

        return view('home.page.single', compact('blog', 'categories', 'totalPost', 'topViewPosts', 'comments'));
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
        $topViewPosts = Post::topViewPosts();

        return view('home.page.blog', compact('posts', 'categories', 'totalPost', 'topViewPosts'));
    }
    // Tim kiem
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return back()->withInput()->with('error', 'Please enter keywords to search!');
        }
        if (strlen($query) > 20) {
            return back()->withInput()->with('error', 'Keyword cannot be longer than 100 characters!');
        }

        $posts = Post::searchPosts($query)->paginate(6);
        $categories = Post::getCategorywithPostCount();
        $totalPost = Post::totalPostCount();
        $topViewPosts = Post::topViewPosts();

        return view('home.page.blog', compact('posts', 'categories', 'totalPost', 'topViewPosts'))->with('query', $query);
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
            'content' => 'required|max:10000',
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
    //like 
    public function toggleLike($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'You need to login ti like this post.'], 403);
        }

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->detach($user->id);
            $post->decrement('like_count');
            $liked = false;
        } else {
            $post->likes()->attach($user->id);
            $post->increment('like_count');
            $liked = true;
        }

        return response()->json(['like_count' => $post->like_count, 'liked' => $liked]);
    }
    //them binh luan
    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'message' => 'required|max:1000',
        ]);

        $post = Post::findOrFail($postId);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'You need to login to comment.'], 403);
        }

        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => $request->message,
        ]);

        return response()->json([
            'id' => $comment->id,
            'user' => [
                'name' => $user->name,
            ],
            'content' => $comment->content,
            'created_at' => $comment->created_at->diffForHumans(),
        ]);
    }

    public function storeReply(Request $request, $commentId)
    {
        $request->validate([
            'message' => 'required|max:1000',
        ]);

        $parentComment = Comment::findOrFail($commentId);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'You need to login to reply.'], 403);
        }

        $reply = Comment::create([
            'user_id' => $user->id,
            'post_id' => $parentComment->post_id,
            'parent_id' => $parentComment->id,
            'content' => $request->message,
        ]);

        return response()->json([
            'id' => $reply->id,
            'user' => [
                'name' => $user->name,
            ],
            'content' => $reply->content,
            'created_at' => $reply->created_at->diffForHumans(),
        ]);
    }
    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $user = Auth::user();

        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'You are not authorized to delete this comment.'], 403);
        }

        // Xóa bình luận
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }
    public function deleteReply($commentId)
    {
        $reply = Comment::findOrFail($commentId);
        $user = Auth::user();

        if ($reply->user_id !== $user->id) {
            return response()->json(['message' => 'You are not authorized to delete this reply.'], 403);
        }

        // Xóa bình luận
        $reply->delete();

        return response()->json(['message' => 'Reply deleted successfully.']);
    }

    public function updateComment(Request $request, $commentId){
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        $comment = Comment::findOrFail($commentId);
        $comment->content = $request->content;
        $comment->save();

        return response()->json([
            'message' => 'Comment updated successfully.',
            'user' => $comment->user,
            'created_at' => $comment->created_at->diffForHumans(),
        ]);
    }
    public function updateReply(Request $request, $commentId){
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        $comment = Comment::findOrFail($commentId);
        $comment->content = $request->content;
        $comment->save();

        return response()->json([
            'message' => 'Reply updated successfully.',
            'user' => $comment->user,
            'created_at' => $comment->created_at->diffForHumans(),
        ]);
    }
}
