<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:create-product')->only('create', 'store');
        $this->middleware('can:edit-product')->only('edit', 'update', 'updateThumbnail');
        $this->middleware('can:delete-product')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $productQuery = Product::with('categories');

        if ($search) {
            $productQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('price', 'like', '%' . $search . '%')
                    ->orWhereHas('categories', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        $validSortColumns = ['name', 'created_at'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'name';
        }

        $productQuery->orderBy($sortBy, $sortOrder);

        $products = $productQuery->paginate(10);

        $title = 'Delete Product!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('dashboard.product.index', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|uuid|exists:categories,uuid',
            'image_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:3072',
        ]);

        if ($request->hasFile('image_thumbnail')) {
            $imagePath = $request->file('image_thumbnail')->store('image_thumbnails', 'public');
            $validatedData['image_thumbnail'] = $imagePath;
        }


        Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'image_thumbnail' => $validatedData['image_thumbnail'],
        ]);

        Alert::success('Create Product Data', 'Product data created has been successfully');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $product = Product::with('categories')->findOrFail($uuid);
        $categories = Category::all();

        return view('dashboard.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|uuid|exists:categories,uuid',
        ]);

        Product::findOrFail($uuid)->update([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
        ]);

        Alert::success('Update Product Data', 'Product data updated has been successfully');
        return redirect()->route('product.index');
    }

    public function updateThumbnail(Request $request, string $uuid)
    {
        $validatedData = $request->validate([
            'image_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:3072',
        ]);

        $product = Product::findOrFail($uuid);

        if ($request->hasFile('image_thumbnail')) {
            if ($product->image_thumbnail && Storage::disk('public')->exists($product->image_thumbnail)) {
                Storage::disk('public')->delete($product->image_thumbnail);
            }

            $imagePath = $request->file('image_thumbnail')->store('image_thumbnails', 'public');
            $validatedData['image_thumbnail'] = $imagePath;
        }

        $product->update([
            'image_thumbnail' => $validatedData['image_thumbnail'],
        ]);

        // Tampilkan pesan sukses
        Alert::success('Update Product Thumbnail', 'Product thumbnail updated successfully');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        // Temukan produk berdasarkan UUID
        $product = Product::findOrFail($uuid);

        if ($product->image_thumbnail) {
            Storage::disk('public')->delete($product->image_thumbnail);
        }

        $product->delete();

        Alert::success('Delete Product Data', 'Product data deleted has been successfully');
        return redirect()->route('product.index');
    }

    public function stockData(Request $request)
    {
        $search = $request->input('search');
        $productQuery = Product::query();

        if ($search) {
            $productQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('stock', 'like', '%' . $search . '%');
            });
        }

        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        $validSortColumns = ['name', 'created_at'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'name';
        }

        $productQuery->orderBy($sortBy, $sortOrder);

        $products = $productQuery->paginate(10);

        return view('dashboard.product.stock-data', compact('products'));
    }
}
