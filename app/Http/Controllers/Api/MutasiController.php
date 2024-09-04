<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mutasi;
use App\Models\Barang;
use App\Models\User;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $list = Mutasi::all();
        if(!$list->isEmpty()){
            return response()->json(['success' => true, 'message' => 'success', 'data' => $list]);
        }else{
            return response()->json(['message' => 'no data exist']);
        }

        // $mutasis = Mutasi::with(['user', 'barang'])->get();
        // return response()->json($mutasis);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_mutasi' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
        ]);

        $mutasi = Mutasi::create($request->all());
        return response()->json(['success' => true, 'message' => 'Data Berhasil ditambahkan' ,'data' => $mutasi], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mutasi $mutasi)
    {
        //
        // $mutasi->load(['user', 'barang']);
        // return response()->json($mutasi);

        $data = Mutasi::find($mutasi);
        if ($data) {
            return response()->json(['success' => true, 'message' => 'data exist' ,'data'=>$data]);
        }
        return response()->json(['message' => 'data not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mutasi $mutasi)
    {
        //
        $request->validate([
            'tanggal' => 'date',
            'jenis_mutasi' => 'string|max:255',
            'jumlah' => 'integer',
            'user_id' => 'exists:users,id',
            'barang_id' => 'exists:barangs,id',
        ]);

        $mutasi->update($request->all());
        return response()->json($mutasi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mutasi $mutasi)
    {
        //
        $mutasi->delete();
        return response()->json(null, 204);
    }

    // Display history for a specific Barang
    public function historyForBarang($id)
    {
        $barang = Barang::findOrFail($id);
        $mutasis = $barang->mutasis;
        if(!$mutasis->isEmpty()){
            return response()->json(['success' => true, 'message' => 'Mutasi Barang Ditemukan', 'data' => $mutasis]);
        }else {
            return response()->json(['success' => true, 'message' => 'Mutasi Barang Tidak Ditemukan', 'data' => $mutasis]);
        }
    }

    // Display history for a specific User
    public function historyForUser($id)
    {
        $user = User::findOrFail($id);
        $mutasis = $user->mutasis;
        if(!$mutasis->isEmpty()){
            return response()->json(['success' => true, 'message' => 'Mutasi User Ditemukan', 'data' => $mutasis]);
        }else {
            return response()->json(['success' => true, 'message' => 'Mutasi User Tidak Ditemukan', 'data' => $mutasis]);
        }
    }
}
