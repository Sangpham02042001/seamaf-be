<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    
    public function getProductsByCategory($categoryId) {
        return Product::with('images')->where('category_id', '=', $categoryId)->take(10)->get();
    }

    public function searchProducts(Request $request) {
        $text = $request->query('text');
        return Product::with('images')
            ->where('name', 'like', '%'.$text.'%')
            ->orWhere('code', 'like', '%'.$text.'%')
            ->take(10)
            ->get();
    }

    public function getProductById($productId) {
        return Product::with('images')
            ->where('id', '=', $productId)
            ->get();
    }

    public function getTopProducts() {
        return Product::with('images')
            ->where('is_top', '=', 1)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get();
    }

    public function getLatestProducts() {
        return Product::with('images')
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get();
    }
}
