<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{



public function store(Request $request)
{
    $order = Order::create($request->all());

    // Enviar o e-mail
    Mail::to($order->client->email)->send(new OrderConfirmation($order));

    return $order;
}

}
