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
}
