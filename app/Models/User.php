<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'special',
        'canceltiket',
        'changeprice',
        'acceptreject',
        'is_commission',
        'commission',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getSpecialAttribute($value)
    {
        if(app()->getLocale()=='en')
        {
            if($this->attributes['special'] == 1)
                return "Special";
            elseif($this->attributes['special'] == 0)
                return 'Not Special';
        }
        else
        {
            if($this->attributes['special'] == 1)
                return "مميز";
            elseif($this->attributes['special'] == 0)
                return 'غير مميز';
        }
    }

    public function bank()
    {
        return $this->hasOne(Bank::class,'user_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class,'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'user_id');
    }
}
