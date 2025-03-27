<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAffiliate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'usernew_id',
        'amount',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'user_id','usernew_id');
    }

}
