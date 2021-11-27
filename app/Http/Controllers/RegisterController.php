<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'email'     => 'required|email|unique:users',
            'phone'     => 'required',
            'country'     => 'required',
            'city'     => 'required',
            'password'  => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'country'   => $request->country,
            'city'      => $request->city,
            'password'  => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register Success!',
            'data'    => $user  
        ]);
    }
}
