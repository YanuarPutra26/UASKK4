<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConcertController extends Controller
{
    public function index()
    {
        $concert = Concert::all();
        $concert->map(function ($concert) {
            $concert->gambar = asset('storage/' . $concert->gambar);
            return $concert;
        });

        if ($concert) {
            return response()->json([
                'status' => 'success',
                'data' => $concert
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found'
            ], 404);
        }
    }



    public function store(Request $request)
    {
        $user = auth()->user();

        $image = $request->file('gambar')->store('concert', 'public');

        $this->validate($request, [
            'nama_konser' => 'required|string|max:255',
            'gambar' => 'required|image',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'tempat' => 'required',
            'harga' => 'required|integer',
        ]);

        if ($user->role == 'admin') {
            $concert = Concert::create([
                'nama_konser' => $request->nama_konser,
                'slug' => Str::slug($request->nama_konser),
                'gambar' => $image,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal,
                'tempat' => $request->tempat,
                'harga' => $request->harga,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk menambahkan data konser'
            ], 401);
        }

        return response()->json([
            'status' => 'Data Konser Berhasil Ditambahkan',
            'data' => $concert
        ]);
    }


    public function show(Concert $concert)
    {
        return response()->json([
            'status' => 'success',
            'data' => $concert
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $concert = Concert::find($id);
        if ($request->file('image')) {
            $image = $request->file('image')->store('concert', 'public');
        } else {
            $image = $concert->image;
        }

        if ($user->role == 'admin') {
            $concert->update([
                'nama_konser' => $request->nama_konser ?? $concert->nama_konser,
                'slug' => Str::slug($request->nama_konser ?? $concert->nama_konser),
                'gambar' => $image ?? $concert->gambar,
                'deskripsi' => $request->deskripsi ?? $concert->deskripsi,
                'tanggal' => $request->tanggal ?? $concert->tanggal,
                'tempat' => $request->tempat ?? $concert->tempat,
                'harga' => $request->harga ?? $concert->harga,
                'status' => $request->status ?? $concert->status,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk mengubah data konser'
            ], 401);
        }

        return response()->json([
            'status' => 'Data Konser Berhasil Diubah',
            'data' => $concert
        ]);
    }

    public function destroy($id)
    {
        $user = auth()->user();

        $concert = Concert::find($id);

        if ($user->role == 'admin') {
            $concert->delete();
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk menghapus data konser'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Konser Berhasil Dihapus'
        ]);
    }
}
