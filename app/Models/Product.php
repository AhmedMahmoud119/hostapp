<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'currency',
        'period_in_month',
        'price',
        'category',
        'type',
        'status',
    ];
}
