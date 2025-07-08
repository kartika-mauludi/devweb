<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'type',
        'link',
        'name',
        'urut',
        'file_location'
        
    ];
}
