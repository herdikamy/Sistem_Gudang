<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $list = User::all();
        if(!$list->isEmpty()){
            return response()->json(['success' => true, 'message' => 'success', 'data' => $list]);
        }else{
            return response()->json(['message' => 'no data exist']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = User::find($id);
        if ($data) {
            return response()->json(['success' => true, 'message' => 'data exist' ,'data'=>$data]);
        }
        return response()->json(['message' => 'data not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
        ]);
    
        // Jika ada password baru, maka kita hash sebelum menyimpannya
        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
    
        // Update data user
        $user->update($validatedData);
    
        // Mengembalikan data user yang telah diperbarui dalam bentuk JSON
        return response()->json(['message' => 'Pembaruan Data Berhasil' ,'data' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $user = User::findOrFail($id);

        $user->delete();

        return response()->json(null, 204);
    }
}
