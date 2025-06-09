<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateDetails extends Model
{
    protected $fillable = [
        'affiliate_comission_id',
        'user_id'
    ];

    public $timestamps = false;

    public function affiliate()
    {
        return $this->belongsTo(AffiliateComission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
