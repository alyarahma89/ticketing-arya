<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPackage extends Model
{
    use HasFactory;

    // Mengizinkan kolom ini diisi dari formulir
    protected $fillable = [
        'event_id', 'name', 'price', 'description', 'quota'
    ];

    // Relasi: Setiap paket tiket ini adalah MILIK SATU event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
