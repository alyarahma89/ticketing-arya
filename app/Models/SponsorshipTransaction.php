<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorshipTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsorship_id',
        'user_id',
        'company_name',
        'company_email',
        'company_phone',
        'message',
        'status',
        'payment_status', // Menambahkan kolom payment_status
    ];

    // Relasi ke tabel Sponsorship
    public function sponsorship()
    {
        return $this->belongsTo(Sponsorship::class);
    }

    // Relasi ke tabel User (Perusahaan/Sponsor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
