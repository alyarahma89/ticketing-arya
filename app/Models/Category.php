<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // MENGGUNAKAN $fillable: Memberitahu sistem bahwa kolom ini aman dan boleh diisi otomatis
    protected $fillable = [
        'name',
        'image',
    ];

    // Relasi: Satu kategori bisa dimiliki oleh banyak event
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
