<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateComission extends Model
{
    protected $fillable = [
        'amount',
        'type'
    ];
}
