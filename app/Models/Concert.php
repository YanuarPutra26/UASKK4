<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concert extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_konser',
        'slug',
        'gambar',
        'deskripsi',
        'tanggal',
        'tempat',
        'harga',
        'status',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
