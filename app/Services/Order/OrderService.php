<?php

namespace App\Services\Order;

use App\Repositories\Order\OrderRepository;
use App\Repositories\Clients\ClientRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use Illuminate\Support\Str;

class OrderService
{
    protected $orderRepository;
    protected $clientRepository;

    public function __construct(OrderRepository $orderRepository,ClientRepository $clientRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->clientRepository = $clientRepository;
    }

    public function getAllOrder()
    {
        return $this->orderRepository->all();
    }

    public function createOrder(array $data)
    {
        $client = $this->clientRepository->find($data['client_id']);

        $code = strtoupper(Str::random(10));


        $order = $this->orderRepository->create([
            'client_id' => $data['client_id'],
            'code' => $code,
        ]);


        foreach ($data['products'] as $product) {
            $order->products()->attach($product['product_id'], ['quantity' => $product['quantity']]);
        }
        Mail::to($client->email)->send(new OrderCreated($order));
        return $order;


    }


    public function updateOrder($id, array $data)
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            throw new \Exception('Order not found.');
        }


        if (isset($data['client_id'])) {
            $order->client_id = $data['client_id'];
        }

        $order->save();


        if (isset($data['products']) && is_array($data['products'])) {

            $syncData = [];
            foreach ($data['products'] as $product) {
                $syncData[$product['product_id']] = ['quantity' => $product['quantity']];
            }
            $order->products()->sync($syncData);
        }

        return $order->load(['client', 'products']);
    }





    public function getOrderById($id)
    {

        $order = $this->orderRepository->find($id);

        if (!$order) {
            throw new \Exception('Order not found.');
        }

        return $this->orderRepository->find($id);
    }

    public function deleteOrder($id)
    {
        $order = $this->orderRepository->find($id);
        if (!$order) {
            throw new \Exception('order not found.');
        }
        return $this->orderRepository->delete($id);
    }

    private function uploadPhoto($photo)
    {
      
        $path = $photo->store('Order', 'public');

        return $path;
    }


}
