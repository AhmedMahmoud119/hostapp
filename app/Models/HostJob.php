<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'event_name',
        'status',

        'error_code',
        'message',
        'json',
    ];
}
