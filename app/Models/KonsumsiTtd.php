<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsumsiTtd extends Model
{
    use HasFactory;

    protected $table = 'konsumsi_ttd';

    protected $fillable = [
        'user_id',
        'tanggal_waktu',
        'total_tablet_diminum',
        'minum_vit_c'
    ];
}
