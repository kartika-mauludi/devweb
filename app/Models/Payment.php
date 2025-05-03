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
        'status',
        'order_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function subscribeRecord()
    {
        return $this->belongsTo(SubscribeRecord::class);
    }


    public function grandtotal()
    {
        $grandtotal = $this->price - ($this->price * $this->discount/100);
        
        return $grandtotal;
    }
}
