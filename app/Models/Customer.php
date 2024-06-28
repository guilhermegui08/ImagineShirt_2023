<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['id','nif', 'address', 'default_payment_type', 'default_payment_ref'];

    public function orderRef(): HasMany
    {
        return $this->hasMany(Order::class, 'id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function orderItems(): BelongsToMany
    {
        return $this->belongsToMany(OrderItem::class, 'orders');
    }
}
