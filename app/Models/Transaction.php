<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'concert_id',
        'user_id',
        'kode_transaksi',
        'nama_pembeli',
        'email_pembeli',
        'no_hp_pembeli',
        'jumlah_tiket',
        'biaya_servis',
        'total_harga',
        'status_transaksi',
    ];

    public function concert()
    {
        return $this->belongsTo(Concert::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
