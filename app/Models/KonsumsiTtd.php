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

    protected $appends = ['total_jumlah_ttd_dikonsumsi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalJumlahTtdDikonsumsiAttribute()
    {
        return $this->where('user_id', $this->user_id)->sum('total_tablet_diminum');
    }
}
