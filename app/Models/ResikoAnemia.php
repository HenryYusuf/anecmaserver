<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResikoAnemia extends Model
{
    use HasFactory;

    protected $table = 'resiko_anemia';

    protected $fillable = [
        'user_id', 'usia_kehamilan', 'jumlah_anak', 'riwayat_anemia', 'konsumsi_ttd_7hari', 'hasil_hb', 'resiko',
    ];

    public function userResiko()
    {
        return $this->belongsTo(User::class);
    }
}
