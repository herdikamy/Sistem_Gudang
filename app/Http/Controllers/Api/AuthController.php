<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if($validated->fails()){
            return response()->json(['success'  => false, 'message' => 'Terjadi Kesalahan', 'detail'  => $validated->errors()]);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        $success['email'] = $user->email;
        $success['name'] = $user->name;
        // $success['password'] = $user->password;

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['success' => true,'access_token' => $token,'token_type' => 'Bearer','user' => $success]);
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Cek kredensial
        if (!Auth::attempt($request->only('email', 'password'))) {
            // return response()->json(['message' => 'Invalid login credentials.'], 401);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Temukan user dan buat token
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return response
        return response()->json(['success' => true, 'access_token' => $token,'token_type' => 'Bearer', 'user' => $user], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully.'], 200);
    }

}
