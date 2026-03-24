<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 1. If admin - Redirect to the admin route defined in web.php
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        // 2. If customer - Show products
        $products = Product::paginate(12);

        return view('home', compact('products'));
    }
}
