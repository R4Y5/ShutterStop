<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // If admin - show admin dashboard
        if (auth()->user()->hasRole('admin')) {
            return view('admin.dashboard');
        }

        // If customer - show home page with products
        $products = Product::paginate(12);

        return view('home', compact('products'));
    }
}
