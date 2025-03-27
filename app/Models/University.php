<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'main_url',
        'signin_url',
        'signout_url',
    ];

    public function websites()
    {
        return $this->belongsToMany(Website::class, 'university_websites');
    }
}
