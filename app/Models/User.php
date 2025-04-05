<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\Passwordreset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use illuminate\Contracts\Auth\CanResetPassword;
use illuminate\Contracts\Auth\MustVerifyEmail ;

class User extends Authenticatable implements CanResetPassword

{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function sendPasswordResetNotification($token){
        $this->notify(new Passwordreset($token));
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nomor',
        'referral_code',
        'bank_account',
        'bank_name',
        'is_superadmin',
        'akun_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'akun_id' => 'array',
        ];
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function affiliates()
    {
        return $this->hasMany(UserAffiliate::class);
    }

    public function subscribeRecord()
    {
        return $this->hasMany(SubscribeRecord::class);
    }

    public function scopeCustomer($query)
    {
        $query->where('is_superadmin', false);
    }

    public function scopeSuperadmin($query)
    {
        $query->where('is_superadmin', true);
    }
}
