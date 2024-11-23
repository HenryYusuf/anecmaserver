<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriEdukasi extends Model
{
    use HasFactory;

    protected $table = 'kategori_edukasi';

    protected $fillable = [
        'kategori_id',
        'edukasi_id',
    ];
}
