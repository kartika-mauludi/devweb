<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribeRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscribe_package_id',
        'user_id',
        'start_date',
        'end_date',
        'account_status',
        'status'
    ];

    public function subscribePackage()
    {
        return $this->belongsTo(SubscribePackage::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
