<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_puskesmas',
        'alamat'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'petugas_puskesmas', 'puskesmas_id', 'user_id');
    }
}
