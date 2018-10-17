<?php

namespace App\Observers;

use App\Models\OrderItem;

class OrderItemObserver
{
    /*Eloquent 的模型触发了几个事件，可以在模型的生命周期的以下几点进行监控：
    retrieved、creating、created、updating、updated、saving、saved、deleting、deleted、restoring、restored
    事件能在每次在数据库中保存或更新特定模型类时轻松地执行代码。*/

    public function created(OrderItem $orderItem)
    {
        // 更新 Sku -库存 & +销量
        $orderItem->sku->decrement('stock', $orderItem->number);
        $orderItem->sku->increment('sales', $orderItem->number);

        // 更新 Product -库存 & +销量 & +综合指数 & +人气|热度
        $orderItem->sku->product->decrement('stock', $orderItem->number);
        $orderItem->sku->product->increment('sales', $orderItem->number);
        $orderItem->sku->product->increment('index', $orderItem->number);
        $orderItem->sku->product->increment('heat');
    }
}
