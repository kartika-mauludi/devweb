<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusesDetails extends Model
{
    protected $fillable = [
        'bonuses_id',
        'user_id'
    ];


    public function bonus()
    {
        return $this->belongsTo(Bonus::class,'bonuses_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
