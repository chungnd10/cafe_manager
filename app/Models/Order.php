<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'table_id',
        'created_by',
        'bartender_id',
        'order_status_id'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function bartender()
    {
        return $this->belongsTo(User::class,'bartender_id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product');
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function completed()
    {
        $order_status_id = config('constants.ORDER_STATUS_COMPLETE');
        return $this->where('id', $order_status_id)->first();
    }
}
