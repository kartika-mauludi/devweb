<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'file',
        'link',
        'name'
    ];
    
    public $timestamps = false;
}
