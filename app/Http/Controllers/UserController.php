<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Htpp\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required'
        ], [
            'email.unique'=> 'Email has already used',
        ]);
        if ($validator->fails()) {
            Log::info('message');
            return response()->json($validator->errors(), 400);
        }
        $postArray = [
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'created_at'=>Carbon::now('Asia/Ho_Chi_Minh'),
            'updated_at'=>Carbon::now('Asia/Ho_Chi_Minh'),
        ];
        $user = User::create($postArray);
        return response()->json(['message'=> 'Signup successfully'], 201);
    }

    public function delete(Request $request, $userId) {
        $res = User::where('id',$userId)->delete();
        if ($res) {
            return response()->json(['message'=> 'Delete successfully'], 200);
        } else {
            return response()->json(['error'=> 'Something wrong'], 400);
        }
    }

    public function update(Request $request, $userId) {
        try {
            $user = User::where('id', $userId)->first();
            $content = $request->all();
            if (array_key_exists('name', $content)) {
                $user->name = $content['name'];
            }
            if (array_key_exists('email', $content)) {
                $user->email = $content['email'];
            }
            if (array_key_exists('role', $content)) {
                $user->role = $content['role'];
            }
            $user->save();
            return response()->json(['message'=> 'Update successfully'], 200);
        } catch (\Throwable $th) {
            // dd($th);
            var_dump($th);
            return response()->json(['error'=> 'Something wrong'], 400);
        }
    }
}
