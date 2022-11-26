<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Concert;

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

    public function show($id)
    {
        $concert = Concert::find($id);
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
}
