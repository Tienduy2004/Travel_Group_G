<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index'); 
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
    //login
    public function login () 
    {
        return view('home.login.login');
    }
    public function register () 
    {
        return view('home.login.register');
    }
}
