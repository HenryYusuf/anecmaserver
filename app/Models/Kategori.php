<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'parent_id',
        'gender'
    ];

    public function kategori_parent()
    {
        return $this->belongsTo(Kategori::class, 'parent_id');
    }

    public function kategori_child()
    {
        return $this->hasMany(Kategori::class, 'parent_id');
    }

    public function edukasi()
    {
        return $this->hasMany(Edukasi::class);
    }

    public function edukasi_pivot()
    {
        return $this->belongsToMany(Edukasi::class, 'kategori_edukasi', 'kategori_id', 'edukasi_id');
    }
}
