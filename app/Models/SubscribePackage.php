<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'discount',
        'days'
    ];

    public function subscribeRecords()
    {
        return $this->hasMany(SubscribeRecord::class);
    }
}
