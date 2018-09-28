<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductSku::class, function (Faker $faker) {
    // 现在时间
    $now = \Carbon\Carbon::now()->toDateTimeString();
    // 随机取一个月以内的时间
    $updated_at = $faker->dateTimeThisMonth($now);
    // 传参为生成最大时间不超过，创建时间永远比更改时间要早
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'product_id' => $faker->randomDigit,
        'name_en' => $faker->name,
        'name_zh' => $faker->name,
        'photo' => $faker->imageUrl(),
        'price' => $faker->randomFloat(2, 10, 100),
        'stock' => $faker->randomNumber(3),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
