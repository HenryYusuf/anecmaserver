<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderTtd extends Model
{
    use HasFactory;

    protected $table = 'reminder_ttd';

    protected $fillable = [
        'user_id',
        'waktu_reminder_1',
        'is_active_reminder_1',
        'waktu_reminder_2',
        'is_active_reminder_2',
    ];
}
