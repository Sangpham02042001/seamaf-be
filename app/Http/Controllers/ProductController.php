<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request) {
        return Product::with(['images', 'category'])->get();
        // return $request->user();
    }
    
    public function create(Request $request) {
        try {
            $content = $request->all();
            $product = Product::create([
                "name"=> $content['name'],
                "description" => $content['description'],
                "price" => $content['price'],
                "category_id" => $content['category_id'],
                "is_top" => $content['is_top'],
                "on_sale" => $content['on_sale']
            ]);
            $productId = $product->id;
            $images = $content['images'];
            for($i = 0; $i < count($images); $i++) {
                Image::create([
                    "product_id" => $productId,
                    "path" => $images[$i]
                ]);
            }
            return Product::with(['images', 'category'])->where('id', $productId)->first();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete(Request $request, $productId) {
        try {
            $res = Product::where('id', $productId)->delete();
            if ($res) {
                return response()->json(['message' => 'Delete successfully'], 200);
            } else {
                return response()->json(['error' => 'Something wrong'], 400);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function update(Request $request, $productId) {
        try {
            $product = Product::where('id', $productId)->first();
            $content = $request->all();
            if ($product) {
                if (array_key_exists('name', $content)) {
                    $product->name = $content['name'];
                }
                if (array_key_exists('category_id', $content)) {
                    $product->category_id = $content['category_id'];
                }
                if (array_key_exists('description', $content)) {
                    $product->description = $content['description'];
                }
                if (array_key_exists('price', $content)) {
                    $product->price = $content['price'];
                }
                if (array_key_exists('is_top', $content)) {
                    $product->is_top = $content['is_top'];
                }
                if (array_key_exists('on_sale', $content)) {
                    $product->on_sale = $content['on_sale'];
                }
                if (array_key_exists('images', $content)) {
                    $res = Image::where('product_id', $productId)->delete();
                    if ($res) {
                        $images = $content['images'];
                        for ($i = 0; $i < count($images); $i++) {
                            Image::create([
                                "product_id" => $productId,
                                "path" => $images[$i]
                            ]);
                        }
                    }
                }
                $product->save();
                return Product::with(['images', 'category'])->where('id', $productId)->first();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

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
