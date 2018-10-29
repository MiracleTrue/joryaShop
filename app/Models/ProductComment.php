<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'user_id',
        'order_id',
        'order_item_id',
        'product_id',
        'composite_index',
        'description_index',
        'shipment_index',
        'content',
        'photos',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * The accessors to append to the model's array form.
     * @var array
     */
    protected $appends = [
        'photo_set',
    ];

    public function getPhotoSetAttribute()
    {
        $photoSet = [];
        if ($this->attributes['photos'] != '') {
            $photos = explode(',', $this->attributes['photos']);
            foreach ($photos as $photo) {
                $photoSet[] = generate_image_url($photo);
            }
        }
        return $photoSet;
    }

    public function children()
    {
        return $this->hasMany(ProductComment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(ProductComment::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
