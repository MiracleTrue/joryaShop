<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'number',
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function productSku ()
    {
        return $this->belongsTo(ProductSku::class);
    }
}
