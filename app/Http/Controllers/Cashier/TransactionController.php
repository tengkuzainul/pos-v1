<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        return view('cashier.index', compact('products', 'categories'));
    }

    /**
     * Get products by category UUID.
     */
    public function getProductByCategory(string $categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();

        if ($products->isEmpty()) {
            return response()->json(['html' => '<p class="text-center h3 my-4">Product not found</p>']);
        }

        $html = '';
        foreach ($products as $product) {
            $html .= view('cashier.partials.product-card', compact('product'))->render();
        }

        return response()->json(['html' => $html]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
