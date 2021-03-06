<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductParam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'param_value_id',
        'name',
        'value',
        'sort'
    ];

    /* Accessors */
    /*public function getNameAttribute()
    {
        return $this->param_value->param->name;
    }

    public function getValueAttribute()
    {
        return $this->param_value->value;
    }*/

    /* Mutators */
    public function setParamValueIdAttribute($value)
    {
        $param_value = ParamValue::with('param')->findOrFail($value);
        $this->attributes['param_value_id'] = $value;
        $this->attributes['name'] = $param_value->param->name;
        $this->attributes['value'] = $param_value->value;
        $this->attributes['sort'] = $param_value->sort;
    }

    /* Eloquent Relationships */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function param_value()
    {
        return $this->belongsTo(ParamValue::class);
    }

    public static $cache_key;
    // Cache 生命周期: 24小时
    protected static $cache_expire_in_minutes = 1440;

    public static function paramNameValues()
    {
        self::$cache_key = config('app.name') . '_param_name_values';
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出 categories 表中所有的数据，返回的同时做了缓存。
        return Cache::remember(self::$cache_key, self::$cache_expire_in_minutes, function () {
            $param_name_values = [];
            self::orderByDesc('sort')->get(['name', 'value'])->each(function ($param) use (&$param_name_values) {
                if (!isset($param_name_values[$param->name])) {
                    $param_name_values[$param->name] = [];
                }
                if (!isset($param_name_values[$param->name][$param->value])) {
                    $param_name_values[$param->name][$param->value] = 1;
                } else {
                    $param_name_values[$param->name][$param->value] += 1;
                }
            });
            return $param_name_values;
        });
    }
}
