<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{

    public function index()
    {
        $order = Transaction::with(['concert'])->where('user_id',  Auth::user()->id)->get();
        $order->map(function ($order) {
            $order->concert->gambar = asset('storage/' . $order->concert->gambar);
            return $order;
        });

        $user = Auth::user();

        if ($user->role == 'user') {
            if ($order) {
                return response()->json([
                    'status' => 'success',
                    'data' => $order
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data not found'
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not user'
            ], 403);
        }
    }
    public function processPaymentTicket(Request $request)
    {
        $user = auth()->user();
        $image = $request->file('gambar')->store('payment', 'public');

        if ($user->role == 'user') {
            $payment = Payment::create([
                'users_id' => $user->id,
                'transaction_id' => $request->transaction_id,
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'gambar' => $image,
                'status_pembayaran' => 'WAITING',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembayaran Gagal'
            ], 403);
        }

        if ($payment) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran Berhasil, Silakan Tunggu Konfirmasi Dari Admin'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembayaran Gagal'
            ], 400);
        }
    }
}
