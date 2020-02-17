<?php

namespace App\Repositories\OrderStatus;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\EloquentRepository;

class OrderStatusRepository extends EloquentRepository
{
    public function getModel()
    {
        return OrderStatus::class;
    }
}
