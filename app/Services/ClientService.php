<?php

namespace App\Services;

use App\Repositories\Clients\ClientRepository;
use Illuminate\Validation\ValidationException;

class ClientService
{
    protected $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getAllClients()
    {
        return $this->clientRepository->all();
    }

    public function createClient(array $data)
    {
        return $this->clientRepository->create($data);
    }

    public function updateClient($id, array $data)
    {
        // Verifica se o cliente existe
        $client = $this->clientRepository->find($id);

        if (!$client) {
            throw new \Exception('Client not found.');
        }

        // Atualiza o cliente com os dados validados
        $client->update($data);
        return $client;
    }


    public function getClientById($id)
    {
        return $this->clientRepository->find($id);
    }

    public function deleteClient($id)
    {
        return $this->clientRepository->delete($id);
    }
}
