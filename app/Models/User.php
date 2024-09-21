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
        'hari_pertama_haid',
        'tempat_tinggal_ktp',
        'tempat_tinggal_domisili',
        'pendidikan_terakhir',
        'pekerjaan',
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

    public function puskesmas()
    {
        return $this->belongsToMany(Puskesmas::class, 'petugas_puskesmas', 'user_id', 'puskesmas_id');
    }

    public function reminder_ttd()
    {
        return $this->hasOne(ReminderTtd::class);
    }
}
