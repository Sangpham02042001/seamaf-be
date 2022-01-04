<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index() {
        return Category::all();
    }

    public function create(Request $request) {
        try {
            $content = $request->all();
            return Category::create([
                'name'=> $content['name']
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error'=> 'Something wrong'], 400);
        }
    }

    public function update(Request $request, $categoryId) {
        $category = Category::where('id', $categoryId)->first();
        $content = $request->all();
        if (array_key_exists('name', $content)) {
            $category->name = $content['name'];
        }
        $category->save();
        return $category;
    }

    public function delete(Request $request, $categoryId) {
        $res = Category::where('id', $categoryId)->delete();
        if ($res) {
            return response()->json(['message'=>'Delete successfully'], 200);
        } else {
            return response()->json(['error'=>'Something wrong'], 400);
        }
    }
}
