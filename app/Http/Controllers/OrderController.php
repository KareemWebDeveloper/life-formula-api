<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrderWithUserAndItems() {
        $orders = Order::with('user' , 'orderItems.product:id,name,price,image,product_description')->get();
        return response()->json(['orders' => $orders],200);
    }
}
