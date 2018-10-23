<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AutoCompleteOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $time_to_complete_order)
    {
        $this->order = $order;
        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($time_to_complete_order);
    }

    // 定义这个任务类具体的执行逻辑
    // 当队列处理器从队列中取出任务时，会调用 handle() 方法
    /**
     * Execute the job.
     * @return void
     * @throws \Throwable
     */
    public function handle()
    {
        // 判断对应的订单是否已经确认
        // 如果已经确认，则不需要确认订单，直接退出
        if ($this->order->completed_at == null && $this->order->status != Order::ORDER_STATUS_RECEIVING) {
            return;
        }
        // 通过事务执行 sql
        DB::transaction(function () {
            // 将订单的 status 字段标记为 completed，即确认订单
            $this->order->update([
                'status' => 'completed',
                'completed_at' => Carbon::now()->toDateTimeString(),
            ]);
        });
    }
}