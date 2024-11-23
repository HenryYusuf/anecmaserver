<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    use HasFactory;

    protected $table = 'edukasi';

    protected $primaryKey = 'id';

    protected $fillable = [
        'created_by',
        'judul',
        'konten',
        'thumbnail',
        'thumbnail_public_id',
        'jenis',
        'kategori',
        'kategori_id',
    ];

    public function kategori_pivot()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_edukasi', 'edukasi_id', 'kategori_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
