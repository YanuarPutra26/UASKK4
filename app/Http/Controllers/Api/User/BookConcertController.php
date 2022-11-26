<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BookConcertController extends Controller
{
    public function store(Concert $concert, Request $request)
    {
        $price = $concert->harga * $request->jumlah_tiket;
        $service = $price * 0.1;

        $user = auth()->user();

        if ($user->role == 'user') {
            $transaction = Transaction::create([
                'concert_id' => $concert->id,
                'user_id' => $user->id,
                'kode_transaksi' => 'TRX' . mt_rand(10000, 99999) . mt_rand(100, 999),
                'nama_pembeli' => $request->nama_pembeli,
                'email_pembeli' => $request->email_pembeli,
                'no_hp_pembeli' => $request->no_hp_pembeli,
                'jumlah_tiket' => $request->jumlah_tiket,
                'biaya_servis' => $service,
                'total_harga' => $price + $service,
                'status_transaksi' => 'PENDING',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to book this concert'
            ], 403);
        }

        if ($transaction) {
            return response()->json([
                'status' => 'Transaksi Berhasil, Silakan Lanjutkan Ke Pembayaran',
                'data' => $transaction
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to book concert'
            ], 400);
        }
    }
}
