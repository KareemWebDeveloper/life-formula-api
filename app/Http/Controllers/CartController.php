<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function AddToCart(Request $request)
    {
        $user = $request->user();
        $userId = $user->id;
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($cart) {
            $cart->quantity = $quantity;
            $cart->save();
        }
        else {
            // If the cart doesn't exist, create a new entry
            $fields = $request->validate([
                'product_id' => 'required|numeric',
                'quantity' => 'numeric',
                // 'sale' => 'numeric',
                // 'price' => 'numeric',
            ]);
            Cart::create([
                'user_id' => $userId,
                'product_id' => $fields['product_id'],
                'quantity' => $fields['quantity'],
                // 'sale' => $fields['sale'],
                // 'price' => $fields['price'],
            ]);
        }
        return response()->json(['message' => 'added to cart'],200);
    }

    public function getUserCart(Request $request) {
        $user = $request->user();
        $cartItems = $user->carts()->with('product')->get();
        return response()->json(['cart' => $cartItems],200);
    }

    public function deleteCart($id) {
        $cartItem = Cart::find($id);
        if ($cartItem) {
        $cartItem->delete();
        return response()->json(['message' => 'product removed from cart'],200);
        }
    }
}
