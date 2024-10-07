<?php

namespace App\Http\Controllers;


use App\Http\Requests\ClientRequest\ClientRequest;
use App\Services\ClientService;
use App\Traits\ApiResponse;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{

    protected $clientService;
    use ApiResponse; // Use the trait directly

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        $clients = $this->clientService->getAllClients();

        return $this->respondWithNoContent($clients);

    }

    public function show($id)
    {

        try {
            // Try create client
            $client = $this->clientService->getClientById($id);
            if($client == null){
                return response()->json(['error' => 'Client not found'], 404);
            }

            return response()->json(['client' => $client], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            
            return response()->json(['error' => 'Client not found'], 404);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(ClientRequest $request)
    {

        try {
            // Try create client

            $client = $this->clientService->createClient($request->validated());
            return response()->json([
                'message' => 'Client created successfully!',
                'client' => $client
            ], 201);
        }   catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação',
                'messages' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao criar produto',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function update(ClientRequest $request, $id)
    {
        try {
            $client = $this->clientService->updateClient($id, $request->validated());

            return response()->json($client, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Client not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {

        try {
            // Try create client
            $deleted = $this->clientService->deleteClient($id);
            return response()->json(['message' => 'Client deleted successfully'], 200);
        } catch (\Exception $e) {
            // Catch the ModelNotFoundException exception and return a friendly message
             return response()->json(['error' => 'Client not found'], 404);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             // Catch any other unexpected exception and return a generic message
             return response()->json(['error' => $e->getMessage()], 500);
         }
    }
}
