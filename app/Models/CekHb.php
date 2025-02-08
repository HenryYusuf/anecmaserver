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
        'usia_kehamilan',
        'hasil_pemeriksaan'
    ];

    protected $appends = ['urutan_periksa'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrutanPeriksaAttribute()
    {
        $allResults = static::where('user_id', $this->user_id)
            ->orderBy('tanggal', 'asc')
            ->pluck('id')
            ->toArray();

        return array_search($this->id, $allResults) + 1;
    }
}
