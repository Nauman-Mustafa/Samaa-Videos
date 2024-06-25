<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function getCategories()
    {
        $categories = Category::where('status', 'Active')->get();
        return response()->json($categories);
    }
}
