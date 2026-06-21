<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contents extends Model
{
    protected $fillable = [
        'card_number',
        'title',
        'price',
        'description',
        'feature',
        'status'
    ];
}
