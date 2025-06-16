<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'username',
        'password',
        'file_location'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
