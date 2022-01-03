<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Htpp\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function index(Request $request) {
        return $request->user();
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:6',
            'role' => 'string'
        ], [
            'email.unique'=> 'Email has already used!',
            'password.min' => 'Password must has at least 6 characters!'
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
        return response()->json(['user' => $user], 201);
    }

}
