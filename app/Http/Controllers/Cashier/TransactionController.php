<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

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

    /**
     * Display the specified resource.
     */
    public function list(Request $request)
    {
        $search = $request->input('search');
        $transactionsQuery = Transaction::with('transactionItems.product', 'invoice');

        if ($search) {
            $transactionsQuery->whereHas('transactionItems.product', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('invoice', function ($query) use ($search) {
                $query->where('invoice_no', 'like', '%' . $search . '%');
            });
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'asc');

        $validSortColumns = ['created_at', 'total_price', 'payment_method'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'created_at';
        }

        $transactionsQuery->orderBy($sortBy, $sortOrder);

        $transactions = $transactionsQuery->paginate(10);

        $title = 'Delete Transaction!';
        $text = "Are you sure you want to delete this transaction?";
        confirmDelete($title, $text);

        return view('cashier.list', compact('transactions'));
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = Cart::session(Auth::user()->id)->getContent();
        $total = Cart::session(Auth::user()->id)->getTotal();
        $user = Auth::user();

        // Validation
        $validatedData = $request->validate([
            'payment_method' => 'required|in:cash,QRIS',
            'payment_amount' => 'nullable|numeric|min:' . $total,
        ], [
            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Payment method must be either cash or QRIS.',
            'payment_amount.required' => 'Payment amount is required.',
            'payment_amount.numeric' => 'Payment amount must be a number.',
            'payment_amount.min' => 'Payment amount must be at least equal to the total.',
        ]);

        if ($cart->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty, cannot process transaction.');
        }

        try {
            DB::beginTransaction();

            // Create transaction
            $transaction = Transaction::create([
                'total_price' => $total,
                'payment_method' => $validatedData['payment_method'],
                'payment_amount' => $validatedData['payment_method'] === 'QRIS' ? $total : $validatedData['payment_amount'],
                'refund_payment' => $validatedData['payment_amount'] > $total ? $validatedData['payment_amount'] - $total : 0,
            ]);

            // Create transaction items
            foreach ($cart as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->uuid,
                    'product_id' => $item->id,
                    'qty' => $item->quantity,
                    'sub_total' => $item->getPriceSum(),
                ]);

                $product = Product::find($item->id);
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }

            // Create invoice
            $invoice =  Invoice::create([
                'invoice_no' => 'INV-' . time(),
                'transaction_id' => $transaction->uuid,
            ]);

            DB::commit();

            // Clear the cart
            Cart::session(Auth::user()->id)->clear();

            return redirect()->back()->with('success', 'Transaction successful')->with('invoice', $invoice);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transaction failed: ' . $e->getMessage());
        }
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
