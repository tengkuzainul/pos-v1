<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoryId = $request->input('category_id');

        if ($categoryId) {
            $products = Product::where('category_id', $categoryId)->get();
        } else {
            $products = Product::all();
        }

        $categories = Category::all();

        $cart = Cart::session(Auth::user()->id)->getContent();
        $total = Cart::getTotal();

        return view('cashier.index', compact('products', 'categories', 'cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        try {
            $product = Product::where('uuid', $request->input('id'))->firstOrFail();

            Cart::session(Auth::user()->id)->add([
                'id' => $product->uuid,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => [
                    'image' => $product->image_thumbnail,
                ],
            ]);

            return redirect()->back()->with('success', 'Successfully added to cart.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add product to cart');
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            // Assuming you use UUID as the identifier
            $item = Cart::session(Auth::user()->id)->get($request->uuid);

            if ($item) {
                Cart::session(Auth::user()->id)->remove($request->uuid);
                return redirect()->back()->with('success', 'Product removed from cart!');
            }

            return redirect()->back()->with('error', 'Item not found in cart.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove item from cart.');
        }
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
