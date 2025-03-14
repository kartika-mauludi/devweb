<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MidtranConfig extends Model
{
    protected $fillable = [
        'environment',
        'sandbox_client_key',
        'sandbox_server_key',
        'production_client_key',
        'production_server_key'
    ];
    
    public $timestamps = false;
}
