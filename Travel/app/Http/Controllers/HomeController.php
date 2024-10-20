<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy tất cả các tour hoặc tùy chỉnh số lượng tour muốn hiển thị
        $tours = Tour::with('destination')->get(); // Lấy các tour kèm địa điểm
        return view('home.index', compact('tours')); // Truyền biến $tours vào view
    }
    public function about()
    {
        return view('home.about'); 
    }
    public function service()
    {
        return view('home.service'); 
    }
    public function tour(Request $request)
    {
        $tours = Tour::paginate(6);
        
        return view('home.package',compact('tours')); 
    }
    public function contact()
    {
        return view('home.contact'); 
    }
    //page
    // public function blog()
    // {
    //     return view('home.page.blog'); 
    // }
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
