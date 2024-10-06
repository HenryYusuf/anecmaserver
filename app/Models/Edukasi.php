<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    use HasFactory;

    protected $table = 'edukasi';

    protected $fillable = [
        'created_by',
        'judul',
        'konten',
        'jenis',
        'kategori',
    ];
}
