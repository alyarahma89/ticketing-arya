<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom ini diisi data secara otomatis
    protected $fillable = [
        'user_id', // <-- Menambahkan kolom user_id
        'name',
        'description',
        'image',
        'category_id', // <-- Menambahkan kolom category_id
        'location',
        'price',
        'online_price',
        'quota',
        'event_date',
        'youtube_link',

    ];

    // 2. TAMBAHKAN FUNGSI RELASI INI DI BAGIAN BAWAH
    public function user()
    {
        // Ini memberitahu sistem bahwa 1 Event dimiliki oleh 1 User (EO)
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu Event punya banyak Transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relasi: Satu Event memiliki banyak paket Sponsorship
    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
