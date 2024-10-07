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
        $Order = Order::findOrFail($id); // Use findOrFail to throw exception if not found
        $Order->update($data);
        return $Order;
    }

    public function delete($id)
    {
        return Order::destroy($id);
    }

    public function findOrderByNameById($name, $OrderId)
    {
        return Order::where('name', $name)
        ->where('id', '!=', $OrderId) // Não considera o Ordere atual
        ->exists();
    }

    public function findOrderByName($name)
    {
        return Order::where('name', $name)
        ->exists();
    }

}
