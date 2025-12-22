<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'pakets';

    protected $fillable = [
        'nama',
        'price',
        'duration',
        'deskripsi',
        'detail_paket',
        'available',
        'sold'
    ];

    protected $casts = [
        'detail_paket' => 'array', // Konversi JSON ke Array Otomatis
        'available' => 'integer',
        'sold' => 'integer'
    ];

    // Relasi dengan Voucher
    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    // Relasi dengan Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Scope untuk paket yang tersedia
    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
    }

    // Mutator untuk mengatur status available
    public function setAvailableAttribute($value)
    {
        $this->attributes['available'] = $value ? 1 : 0;

        // Reset penjualan jika di-non-aktifkan
        if ($value == 0) {
            $this->attributes['sold'] = 0;
        }
    }

    // Accessor untuk menampilkan status paket
    public function getStatusAttribute()
    {
        return $this->available ? 'Aktif' : 'Non-Aktif';
    }

    // Method untuk memeriksa ketersediaan voucher
    public function hasAvailableVouchers()
    {
        return $this->vouchers()->where('status', 'available')->exists();
    }

    public function getSoldCountAttribute()
    {
        return $this->vouchers()->where('status', 'nonaktif')->count();
    }

}
