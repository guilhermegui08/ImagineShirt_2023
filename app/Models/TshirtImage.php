<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TshirtImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'created_at'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class , 'tshirt_image_id', 'id');
    }

    protected function fullTshirtImageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if($this->customer_id == null) {
                    return $this->image_url ? asset('storage/tshirt_images/' . $this->image_url) :
                        asset('/img/avatar_unknown.png');
                }
                return $this->image_url ? route('tshirt_images.private', ['image' => $this->image_url]) :
                    asset('/img/avatar_unknown.png');
            },
        );
    }
}
