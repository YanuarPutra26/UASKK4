<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index()
    {
        $transaction = Transaction::with(['concert'])->get();
        $transaction->map(function ($transaction) {
            $transaction->concert->gambar = asset('storage/' . $transaction->concert->gambar);
            return $transaction;
        });

        $user = auth()->user();

        if ($user->role == 'admin') {
            if ($transaction) {
                return response()->json([
                    'status' => 'success',
                    'data' => $transaction
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
                'message' => 'You are not admin'
            ], 403);
        }
    }

    public function show($id)
    {
        $data = Transaction::findOrfail($id);
        $payment = Payment::where('transaction_id', $id)->first();
        $payment->gambar = asset('storage/' . $payment->gambar ?? '');

        $user = auth()->user();

        if ($user->role == 'admin') {
            if ($data) {
                return response()->json([
                    'status' => 'success',
                    'data' => $data,
                    'payment' => $payment
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
                'message' => 'You are not admin'
            ], 403);
        }
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id)->update(['status_transaksi' => 'SUCCESSFUL']);

        $user = auth()->user();

        if ($user->role == 'admin') {
            if ($transaction) {
                return response()->json([
                    'status' => 'Transaksi Berhasil Di Update, Pembayaran Sukses',
                    'data' => $transaction
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
                'message' => 'You are not admin'
            ], 403);
        }
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id)->delete();

        $user = auth()->user();

        if ($user->role == 'admin') {
            if ($transaction) {
                return response()->json([
                    'status' => 'success',
                    'data' => $transaction
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
                'message' => 'You are not admin'
            ], 403);
        }
    }
}
