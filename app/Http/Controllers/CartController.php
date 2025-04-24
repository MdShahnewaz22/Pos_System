<?php

namespace App\Http\Controllers;

use App\Models\Shippingdetail;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);
    
        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $price = $request->input('price');
        $image = $request->input('image');
    
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $productName,
                'price' => $price,
                'quantity' => 1,
                'image' => $image
            ];
        }
    
        session()->put('cart', $cart);
    
        return back()->with('success', 'Product added to cart!');
    }

    public function removeFromCart(Request $request)
{
    $productId = $request->input('product_id');
    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        unset($cart[$productId]);
        session()->put('cart', $cart);
    }

    return back();
}

public function incrementCart(Request $request)
{
    $cart = session()->get('cart', []);
    $id = $request->input('product_id');

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
        session()->put('cart', $cart);
    }

    return response()->json(['cart' => $cart]);
}

public function decrementCart(Request $request)
{
    $cart = session()->get('cart', []);
    $id = $request->input('product_id');

    if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
        $cart[$id]['quantity']--;
        session()->put('cart', $cart);
    }

    return response()->json(['cart' => $cart]);
}

public function store(Request $request)
{
    // dd($request->all());
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:1000',
        'payment_status' => 'required|in:cash_on_delivery,credit_card,bank_transfer,paypal,mobile_payment',
        'subtotal' => 'required|numeric|min:0',
    ]);
    

    // Store data in the orders table
    Shippingdetail::create($validated);
    session()->forget('cart');

    return back()->with('success', 'Order placed successfully!');
}



}

