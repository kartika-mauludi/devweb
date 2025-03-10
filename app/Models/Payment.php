<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'subscribe_record_id', 
        'id_invoice', 
        'price', 
        'discount', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscribeRecord()
    {
        return $this->belongsTo(SubscribeRecord::class);
    }
}
