<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function submitRating(Request $request)
    {
        $user = $request->user();
        $userId = $user->id;

        $request->validate([
            'product_id' => 'required',
            'rating' => 'required|numeric',
            'comment' => 'string',
        ]);
        ProductRating::create([
            'product_id' => $request->product_id,
            'user_id' => $userId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return response()->json(['message' => 'rating saved'],200);
    }

    public function getProductAverageRating($productId) {
        $product = Product::with('ratings')->find($productId);

        $averageRating = $product->ratings->avg('rating');

        return response()->json(['rating' => $averageRating ],200);
    }

    public function getProducts(){
        $products = Product::get();
        return response()->json(['products' => $products]);
    }

    public function ProductFind($id){
        $product = Product::find($id);
        return response()->json(['product' => $product],200);
    }

    public function getFeaturedProducts(){
        $Featured = Product::where('featured', true)->get();
        return response()->json(['Featured' => $Featured]);
    }

    public function destroyProduct(Request $request, $id){
        $user = $request->user();
        if($user->type == 'moderator' || $user->type == 'admin'){
        $product = Product::find($id);
        $product->delete();
        return response()->json(['message' => 'product is deleted'],200);
        }
        else{
            return response()->json(['message' => 'not authorized'],401);
        }
    }

    public function createProduct(Request $request){
        $user = $request->user();
        $category = Category::find($request->category_id);
        if($user->type == 'moderator' || $user->type == 'admin'){
        $fields = $request->validate([
            'name' => 'required|string',
            'count' => 'required|numeric',
            'price' => 'required',
            'image' => 'string',
            'featured' => 'boolean',
            'category_id' => 'required|numeric',
            'sale' => 'numeric',
            'old_price' => 'numeric',
            'how_to_take_it' => 'required|string',
            'ingredients_image' => 'required_if:ingredients_text,null|string',
            'ingredients_text' => 'required_if:ingredients_image,null|string',
            'product_description' => 'required|string',
            'product_article' => 'string',
            'product_icons' => 'json',
            'sale_on_3' => 'numeric',
            'sale_on_6' => 'numeric',
            'sale_on_9' => 'numeric',
        ]);
        $fields['categoryName'] = $category->name;

        $product = Product::create($fields);

        // return response()->json(['category' => $category->name],200);
        return response()->json(['product' => $product , 'category' => $category],200);
    }
        else{
            return response()->json(['message' => 'not authorized'],401);
        }
    }

    public function updateProduct(Request $request , $id){
        $user = $request->user();
        $product = Product::find($id);
        if($user->type == 'moderator' || $user->type == 'admin'){
        $fields = $request->validate([
            'name' => 'required|string',
            'count' => 'required|numeric',
            'price' => 'required',
            'image' => 'string',
            'featured' => 'boolean',
            'category_id' => 'required|numeric',
            'sale' => 'numeric',
            'old_price' => 'required_if:sale,!=,null|numeric',
            'how_to_take_it' => 'required|string',
            'ingredients_image' => 'required_if:ingredients_text,null|string',
            'ingredients_text' => 'required_if:ingredients_image,null|string',
            'product_description' => 'required|string',
            'product_article' => 'string',
            'product_icons' => 'json',
            'sale_on_3' => 'numeric',
            'sale_on_6' => 'numeric',
            'sale_on_9' => 'numeric',
        ]);
        $product->update($fields);

        return response()->json(['product' => $product],200);
    }
        else{
            return response()->json(['message' => 'not authorized'],401);
        }
    }
    public function getProductsBlog(Request $request) {
        $Articles = Product::pluck('product_article');
        return response()->json(['blog' => $Articles],200);
    }


}
