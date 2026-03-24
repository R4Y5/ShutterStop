<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductPhoto;
use App\Imports\ProductsImport;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    // Customer-facing shop listing
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        return view('products.index', compact('products'));
    }

    // Admin-facing index
    public function adminIndex()
    {
        return view('products.index'); // reuse your existing Blade file
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'nullable|string|in:Sony,Canon,Nikon',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'photos.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product = Product::create($request->only([
            'name','brand','description','price','stock','category_id'
        ]));

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $filename = time() . '-' . $photo->getClientOriginalName();
                $path = $photo->storeAs('products', $filename, 'public');

                if ($index === 0) {
                    $product->photo = $path;
                    $product->save();
                }

                $product->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'nullable|string|in:Sony,Canon,Nikon',
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

                if ($index === 0) {
                    $product->photo = $path;
                    $product->save();
                }

                $product->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.index')->with('success', 'Product restored successfully!');
    }

    public function forceDestroy($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if ($product->photo) {
            $path = str_replace('storage/', '', $product->photo);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        foreach ($product->photos as $photo) {
            $path = str_replace('storage/', '', $photo->path);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $photo->delete();
        }

        $product->forceDelete();

        return redirect()->route('admin.products.index')->with('success', 'Product permanently deleted!');
    }

    public function getData(Request $request)
    {
        $query = Product::with(['category','photos'])->select('products.*');

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
            ->addColumn('category', fn($product) => $product->category ? $product->category->name : 'Uncategorized')
            ->addColumn('actions', fn($product) => view('products.partials.actions', compact('product'))->render())
            ->editColumn('created_at', fn($product) => $product->created_at ? $product->created_at->format('Y-m-d') : '')
            ->rawColumns(['photo','actions'])
            ->toJson();
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        Excel::import(new ProductsImport, $request->file('file'));
        return redirect()->route('admin.products.index')->with('success', 'Products imported successfully!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function deletePhoto($id)
    {
        $photo = ProductPhoto::findOrFail($id);

        $path = str_replace('storage/', '', $photo->path);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $photo->delete();

        return response()->json(['success' => true]);
    }

    public function getTrashedData(Request $request)
    {
        $query = Product::onlyTrashed()->with(['category','photos'])->select('products.*');

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
            ->addColumn('category', fn($product) => $product->category ? $product->category->name : 'Uncategorized')
            ->addColumn('actions', fn($product) => view('products.partials.actions', compact('product'))->render())
            ->editColumn('deleted_at', fn($product) => $product->deleted_at ? $product->deleted_at->format('Y-m-d') : '')
            ->rawColumns(['photo','actions'])
            ->toJson();
    }
}
