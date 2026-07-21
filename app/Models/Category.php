<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Mematikan syarat perlindungan agar semua kolom (seperti 'name') bisa diisi otomatis
    protected $guarded = [];

    // Relasi: Satu kategori bisa dimiliki oleh banyak event
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
