<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentCompany extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'sort',
    ];

    /**
     * Indicates if the model should be timestamped.
     * @var bool
     */
    public $timestamps = false;
}
