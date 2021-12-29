<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    
    public function getProductsByCategory($categoryId) {
        return Product::with('images')->where('category_id', '=', $categoryId)->get();
    }
}
