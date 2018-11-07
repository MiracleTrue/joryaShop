<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_sku_id',
        'number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sku()
    {
        return $this->belongsTo(ProductSku::class, 'product_sku_id');
    }
}
