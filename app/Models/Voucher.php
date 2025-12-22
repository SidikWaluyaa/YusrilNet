<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = ['paket_id', 'nama', 'username', 'password', 'price',      // tambahkan price
    'duration', 'available', 'status'];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
    public function order()
    {
        return $this->hasOne(Order::class, 'voucher_id');
    }
}
