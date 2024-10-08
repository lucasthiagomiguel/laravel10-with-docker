<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Services\Order\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{

    protected $orderService;
    use ApiResponse; // Use the trait directly

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getAllOrder();

        return $this->respondWithNoContent($orders);

    }

    public function show($id)
    {
        try {
            $order = $this->orderService->getOrderById($id);
            return response()->json(['order' => $order], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Order not found'], 404);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function store(StoreOrderRequest $request)
    {
        try {

            $order = $this->orderService->createOrder($request->validated());

            return response()->json([
                'message' => 'Request created successfully',
                'order' => $order->load(['client', 'products']),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação',
                'messages' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e ) {
            return response()->json([
                'error' => 'Error creating order',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(StoreOrderRequest $request, $id)
    {
        try {
            $order = $this->orderService->updateOrder($id, $request->validated());

            return response()->json($order, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Order not found'], 404);
        } catch ( \Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {

        try {
            // Try create client
            $deleted = $this->orderService->deleteOrder($id);
            return response()->json(['message' => 'Order deleted successfully'], 200);
        } catch (\Exception $e) {
            // Catch the ModelNotFoundException exception and return a friendly message
             return response()->json(['error' => 'Order not found'], 404);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             // Catch any other unexpected exception and return a generic message
             return response()->json(['error' => $e->getMessage()], 500);
         }
    }


}
