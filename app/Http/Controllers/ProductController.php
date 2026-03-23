<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Http\Imports\ProductsImport;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Product::query();

    // Filter by price range
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    // Filter by category
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    // Filter by brand
    if ($request->filled('brand')) {
        $query->where('brand_id', $request->brand);
    }

    // Filter by type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Search keyword
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $products = $query->paginate(12);

    return view('products.index', compact('products'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'photos.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Create product first
        $product = Product::create($request->only([
            'name','brand','description','price','stock','category_id'
        ]));

        // Handle multiple photo uploads
        if ($request->hasFile('photos')) {
    foreach ($request->file('photos') as $index => $photo) {
        $filename = time() . '-' . $photo->getClientOriginalName();
        $path = $photo->storeAs('products', $filename, 'public');

        // Save first photo as the main product photo
        if ($index === 0) {
            $product->photo = $path;
            $product->save();
        }

        // Save all photos into product_photos table
        $product->photos()->create(['path' => $path]);
    }
}

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'photos.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product->update($request->only([
            'name','brand','description','price','stock','category_id'
        ]));

        if ($request->hasFile('photos')) {
    foreach ($request->file('photos') as $index => $photo) {
        $filename = time() . '-' . $photo->getClientOriginalName();
        $path = $photo->storeAs('products', $filename, 'public');

        // Save first photo as the main product photo
        if ($index === 0) {
            $product->photo = $path;
            $product->save();
        }

        // Save all photos into product_photos table
        $product->photos()->create(['path' => $path]);
    }
}

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->photo && Storage::disk('public')->exists($product->photo)) {
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Products DataTable
     */
    public function getData(Request $request)
    {
        $query = Product::with('category')->select('products.*');

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->brand) {
            $query->where('brand', $request->brand);
        }

        return DataTables::of($query)
            ->addColumn('photo', function ($product) {
                if ($product->photos->count()) {
                    $first = $product->photos->first();
                    return '<img src="'.asset('storage/'.$first->path).'" width="50" class="rounded">';
                }
                return '<span class="text-muted">No photo</span>';
            })
            ->addColumn('category', function ($product) {
                return $product->category ? $product->category->name : 'Uncategorized';
            })
            ->addColumn('actions', function ($product) {
                return view('products.partials.actions', compact('product'))->render();
            })
            ->editColumn('created_at', fn($product) => $product->created_at->format('Y-m-d'))
            ->rawColumns(['photo','actions'])
            ->make(true);
        }

    // For soft deletes
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('products.index')->with('success', 'Product restored successfully!');
    }

    // For excel
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        Excel::import(new ProductsImport, $request->file('file'));
        return redirect()->route('products.index')->with('success', 'Products imported successfully!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function deletePhoto($id)
    {
        $photo = \App\Models\ProductPhoto::findOrFail($id);

        // Delete file from storage
        if (Storage::disk('public')->exists($photo->path)) {
            Storage::disk('public')->delete($photo->path);
        }

            $photo->delete();

        return response()->json(['success' => true]);
    }

    public function getTrashedData(Request $request)
    {
        $query = Product::onlyTrashed()->with('category')->select('products.*');

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->brand) {
            $query->where('brand', $request->brand);
        }

        return DataTables::of($query)
            ->addColumn('photo', function ($product) {
                if ($product->photos->count()) {
                    $first = $product->photos->first();
                    return '<img src="'.asset('storage/'.$first->path).'" width="50" class="rounded">';
                }
                return '<span class="text-muted">No photo</span>';
            })
            ->addColumn('category', function ($product) {
                return $product->category ? $product->category->name : 'Uncategorized';
            })
            ->addColumn('actions', function ($product) {
                return view('products.partials.actions', compact('product'))->render();
            })
            ->editColumn('deleted_at', fn($product) => $product->deleted_at->format('Y-m-d'))
            ->rawColumns(['photo','actions'])
            ->make(true);
        }
}   