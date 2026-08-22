<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: Foto ini milik Event apa?
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
