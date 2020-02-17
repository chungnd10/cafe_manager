<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\EloquentRepository;

class OrderRepository extends EloquentRepository
{
    public function getModel()
    {
        return Order::class;
    }

    public function getAll()
    {
        $orders = $this->_model->with('table', 'bartender', 'createdBy', 'orderStatus')
            ->latest('id')
            ->get();

        return $orders;

    }

    public function find($id)
    {
        $result = $this->_model->with('orderProduct', 'products','table', 'bartender', 'createdBy', 'orderStatus')
            ->find($id);
        return $result;
    }
}
