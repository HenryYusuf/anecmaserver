<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usia',
        'no_hp',
        'tempat_tinggal_ktp',
        'tempat_tinggal_domisili',
        'pendidikan_terakhir',
        'pekerjaan',
        'hari_pertama_haid',
        'wilayah_binaan',
        'kelurahan',
        'kecamatan',
        'tempat_periksa_kehamilan',
        'nama_suami',
        'no_hp_suami',
        'email_suami',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function resikoAnemia()
    {
        return $this->hasMany(ResikoAnemia::class);
    }

    public function resikoAnemiaTerbaru()
    {
        return $this->hasOne(ResikoAnemia::class)->latestOfMany();
    }

    public function puskesmas()
    {
        return $this->belongsToMany(Puskesmas::class, 'petugas_puskesmas', 'user_id', 'puskesmas_id');
    }

    public function konsumsi_ttd()
    {
        return $this->hasMany(KonsumsiTtd::class);
    }

    public function reminder_ttd()
    {
        return $this->hasOne(ReminderTtd::class);
    }

    public function wives()
    {
        return $this->hasMany(User::class, 'email_suami', 'email');
    }

    public function riwayat_hb()
    {
        return $this->hasOne(CekHb::class)->latestOfMany();
    }

    public function cekHb()
    {
        return $this->hasMany(CekHb::class);
    }

    public function jurnal_makan()
    {
        return $this->hasMany(JurnalMakan::class);
    }

    // public function jurnal_makan_sorted()
    // {
    //     return $this->hasMany(JurnalMakan::class)->orderBy('tanggal', 'asc');
    // }
}
