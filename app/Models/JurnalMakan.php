<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalMakan extends Model
{
    use HasFactory;

    protected $table = 'jurnal_makan';

    protected $fillable = [
        'user_id',
        'tanggal',
        'sarapan_karbohidrat',
        'sarapan_lauk_hewani',
        'sarapan_lauk_nabati',
        'sarapan_sayur',
        'sarapan_buah',
        'makan_siang_karbohidrat',
        'makan_siang_lauk_hewani',
        'makan_siang_lauk_nabati',
        'makan_siang_sayur',
        'makan_siang_buah',
        'makan_malam_karbohidrat',
        'makan_malam_lauk_hewani',
        'makan_malam_lauk_nabati',
        'makan_malam_sayur',
        'makan_malam_buah',
        'total_kalori',
    ];
}