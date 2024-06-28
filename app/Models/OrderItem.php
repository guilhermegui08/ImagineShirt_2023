<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items';
    public $timestamps = false;
    protected $fillable = [
        'order_id', 'tshirt_image_id', 'color_code', 'size', 'qty',
        'unit_price', 'sub_total'
    ];

    public function orderRef(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function tshirtImage(): BelongsTo
    {
        return $this->belongsTo(TshirtImage::class , 'tshirt_image_id', 'id');
    }
}
