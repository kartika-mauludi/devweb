<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigAdmin extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'nomor',
        'bank_account'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
