<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $list = Barang::all();
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
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255'
        ]);

        $barang = Barang::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Barang Berhasil ditambahkan' ,'data' => $barang], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Barang::find($id);
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
        $barang = Barang::findOrFail($id);
        
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255'
        ]);
    
        $barang->update($validatedData);
    
        return response()->json(['message' => 'Barang Berhasil diperbarui' ,'data' => $barang]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = Barang::findOrFail($id);

        $user->delete();

        return response()->json(null, 204);
    }
}
