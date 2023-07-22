<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddToHostBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'host_bill_id',
        'error_code',
        'message',
        'data',
    ];
}
