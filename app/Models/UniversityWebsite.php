<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityWebsite extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'title',
        'url'
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

}
