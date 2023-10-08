<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $Categories = Category::get();
        return response()->json(['Categories' => $Categories]);
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $category = Category::create([
            'name' => $request->name,
        ]);
        return response()->json(['category' => $category],200);
    }
    public function destroyCategory(Request $request, $id){
        $user = $request->user();
        if($user->type == 'moderator' || $user->type == 'admin'){
        $category = Category::find($id);
        $category->delete();
        return response()->json(['message' => 'category is deleted'],200);
        }
        else{
            return response()->json(['message' => 'not authorized'],401);
        }
    }
    public function updateCategory(Request $request, $id){
        $user = $request->user();
        if($user->type == 'moderator' || $user->type == 'admin'){
        $fields = $request->validate([
            'name' => 'required|string',
        ]);
        $category = Category::find($id);
        $category->update($fields);
        return response()->json(['message' => 'category is updated'],200);
        }
        else{
            return response()->json(['message' => 'not authorized'],401);
        }
    }
}
