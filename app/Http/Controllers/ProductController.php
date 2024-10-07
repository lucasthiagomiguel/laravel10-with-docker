<?php

namespace App\Http\Controllers;

use App\Services\Products\ProductsService;
use App\Http\Requests\ProductRequest\ProductRequest;
use App\Traits\ApiResponse;
use Illuminate\Database\QueryException;
use Exception;

class ProductController extends Controller
{
    protected $productsService;
    use ApiResponse; // Use the trait directly

    public function __construct(ProductsService $productsService)
    {
        $this->productsService = $productsService;
    }

    public function index()
    {
        $productss = $this->productsService->getAllProducts();

        return $this->respondWithNoContent($productss);

    }

    public function show($id)
    {

        try {
            // Try create products
            $products = $this->productsService->getproductsById($id);
            if($products == null){
                return response()->json(['error' => 'products not found'], 404);
            }

            return response()->json(['products' => $products], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
           // Catch the ModelNotFoundException exception and return a friendly message
            return response()->json(['error' => 'products not found'], 404);
        } catch (\Exception $e) {
            // Catch any other unexpected exception and return a generic message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            // Try create products
            $products = $this->productsService->createproducts($request->validated());
            return response()->json([
                'message' => 'products created successfully!',
                'products' => $products
            ], 201);
        } catch (QueryException $e) {
            // Captura erros relacionados ao banco de dados
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (Exception $e) {
            // Captura quaisquer outras exceções
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }



    public function update(ProductRequest $request, $id)
    {
        try {
            $products = $this->productsService->updateproducts($id, $request->validated());

            return response()->json([
                'message' => 'products updated successfully!',
                'products' => $products
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'products not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {

        try {
            // Try create products
            $this->productsService->deleteproducts($id);

            return response()->json(['message' => 'products deleted successfully'], 200);
        } catch (\Exception $e) {
           // Catch the ModelNotFoundException exception and return a friendly message
            return response()->json(['error' => 'products not found'], 404);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Catch any other unexpected exception and return a generic message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
