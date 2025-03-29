<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id', 
        'username', 
        'password'
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
