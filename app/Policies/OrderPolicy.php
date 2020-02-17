<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;


    public function edit(User $user, Order $order)
    {
        $completed_status = config('constants.ORDER_STATUS_COMPLETE');
        return $user->can('update-orders') && $order->order_status_id != $completed_status;
    }


    public function update(User $user, Order $order)
    {
        $completed_status = config('constants.ORDER_STATUS_COMPLETE');
        return $user->can('update-orders') && $order->order_status_id != $completed_status;
    }


    public function delete(User $user, Order $order)
    {
        $completed_status = config('constants.ORDER_STATUS_COMPLETE');
        return $user->can('delete-orders') && $order->order_status_id != $completed_status;
    }

}
