<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'code','name'
    ];
    public $timestamps = false;
    protected $primaryKey = 'code';
    public $incrementing = false;

    protected function fullTshirtBaseUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->code ? asset('storage/tshirt_base/' . $this->code.'.jpg') :
                    asset('/img/avatar_unknown.png');
            },
        );
    }
}
