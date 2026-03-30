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
    
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

    
        $products = Product::paginate(12);

        return view('home', compact('products'));
    }
}
