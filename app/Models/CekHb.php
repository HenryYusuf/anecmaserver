<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CekHb extends Model
{
    use HasFactory;

    protected $table = 'cek_hb';

    protected $fillable = [
        'user_id',
        'tanggal',
        'nilai_hb',
    ];
}
