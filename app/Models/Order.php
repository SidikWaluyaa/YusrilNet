<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_id', 'voucher_id', 'nama', 'email', 'harga', 'status','user_id', 'snap_token'
    ];

    // Relasi ke Paket
    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    // Relasi ke Voucher (jika ada)
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}

