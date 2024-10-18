<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;

class HomeController extends Controller
{
    public function index()
    {
      // Lấy danh sách các tour từ database
    $tours = Tour::all(); // Lấy tất cả các bản ghi từ bảng tours

    // Truyền biến $tours vào view
    return view('home.index', compact('tours')); 
    }
    public function about()
    {
        return view('home.about'); 
    }
    public function service()
    {
        return view('home.service'); 
    }
    public function tour()
    {
        return view('home.package'); 
    }
    public function contact()
    {
        return view('home.contact'); 
    }
    //page
    public function blog()
    {
        return view('home.page.blog'); 
    }
    public function destination()
    {
        return view('home.page.destination'); 
    }
    public function guide()
    {
        return view('home.page.guide'); 
    }
    public function single()
    {
        return view('home.page.single'); 
    }
    public function testimonial()
    {
        return view('home.page.testimonial'); 
    }
}
