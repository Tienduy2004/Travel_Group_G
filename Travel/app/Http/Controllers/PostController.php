<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Crypt;
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

        if($blog){
            return abort(404);
        }

        $categories = Post::getCategorywithPostCount();
        $totalPost = Post::totalPostCount();

        return view('home.page.blog', compact('blog', 'categories', 'totalPost'));
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

        $posts = Post::searchPosts($query)->paginate(6);
        $categories = Post::getCategorywithPostCount();
        $totalPost = Post::totalPostCount();

        return view('home.page.blog', compact('posts', 'categories', 'totalPost'))->with('query', $query);
    }
    public function create_post(){
        return view('home.page.create_post');
    }
}
