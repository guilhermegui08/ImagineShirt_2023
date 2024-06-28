<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'user_type', 'remember_token', 'blocked', 'photo_url'];

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
    ];

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'id');
    }

    protected function fullPhotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->photo_url ? asset('storage/photos/' . $this->photo_url) : asset('/img/avatar_unknown.png');
            },
        );
    }
}
