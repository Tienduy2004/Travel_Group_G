<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Models\Promotion;

class HomeController extends Controller
{
    public function index()
    {
        $hasPromotions = Promotion::exists();
    
        
        $tours = Tour::with('destination')->get();
        
        return view('home.index', compact('tours', 'hasPromotions'));
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
        $tours = Tour::getActiveToursWithDestination(6); // Lấy 6 tour đang hoạt động

        $budgets = Budget::all();
        return view('home.package', compact('tours', 'budgets'));
    }

    public function searchSuggestions(Request $request)
    {
        
        //dd($request->get('destination'));
        $destination = $request->input('destination');
        
        // Lấy danh sách các địa điểm từ cơ sở dữ liệu dựa trên từ khóa
        $suggestions =  Destination::getSuggestions($destination);
        return response()->json($suggestions);
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
