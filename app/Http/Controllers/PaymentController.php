<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request) {
        Stripe::setApiKey('sk_test_51NlVKQKQG7NeLaUwLDJM0AAINN7NTUTZfOlHIqVWiXm5RqxQQkU510MVfxkqXpif0xMbpI9bWRoIKSVB0FInkrtI00TYllRceL');

        $products = $request->input('products');

        // Build the line_items array dynamically
        $lineItems = [];
        foreach ($products as $product) {
            $price = $product['product']['price'];
            if($product['quantity'] >= 3 && $product['quantity'] < 6){
                $price = $price - ($product['product']['price'] * $product['product']['sale_on_3']);
            } elseif($product['quantity'] >= 6 && $product['quantity'] < 9){
                $price = $price - ($product['product']['price'] * $product['product']['sale_on_6']);
            } elseif($product['quantity'] >= 9){
                $price = $price - ($product['product']['price'] * $product['product']['sale_on_9']);
            }
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product['product']['name'],
                        'images' => [$product['product']['image']],
                        'description' => $product['product']['categoryName']
                    ],
                    'unit_amount' => $price * 100, // Convert price to cents
                ],
                'quantity' => $product['quantity'],
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => 'http://localhost:5173/products',
            'cancel_url' => 'http://localhost:5173/',
        ]);

        // return response($session->id);
        return response()->json(['sessionId' => $session->id],200);
    }
}

