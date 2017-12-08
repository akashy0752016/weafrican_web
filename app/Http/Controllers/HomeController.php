<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Weafricans - Connecting African Businesses, Services and Event Management";
        $metaDescription = "New opportunity to every businessperson who wants to do business in Nigeria, Kenya, South Africa. Weafricans.com provide business services facility online.";
        $flag = 1;
        return view('home', compact('pageTitle', 'flag', 'metaDescription'));
    }
}
