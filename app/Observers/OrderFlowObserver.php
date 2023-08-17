<?php

namespace App\Observers;

use App\Models\OrderFlow;
use App\Notifications\NewOrderFlow;

class OrderFlowObserver
{
    public function created(OrderFlow $orderFlow): void
    {
        $orderFlow->load([
                             'user',
                             'order.orderSituation',
                             'order.registered',
                             'order.assigned',
                         ]);

        $orderFlow->order->registered->notify(new NewOrderFlow($orderFlow));

        if ($orderFlow->order->assigned()->exists()) {
            $orderFlow->order->assigned->notify(new NewOrderFlow($orderFlow));
        }
    }
}
