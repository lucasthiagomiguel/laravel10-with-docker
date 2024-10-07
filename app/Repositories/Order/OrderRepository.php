<?php

namespace App\Repositories\Order;


use App\Models\Order;

class OrderRepository
{
    public function all()
    {
        return Order::with(['client', 'products'])->paginate(10);
    }

    public function find($id)
    {
        return Order::find($id);
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function update($id, array $data)
    {
        $order = Order::find($id);
        $order->update($data);
        return $order;
    }

    public function delete($id)
    {

        $order = Order::find($id);
        if ($order) {
            return $order->delete();
        }
        return false;
    }



}
