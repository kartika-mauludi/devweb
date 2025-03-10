<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'url'
    ];

    public function universities()
    {
        return $this->belongsToMany(University::class, 'university_websites');
    }

}
