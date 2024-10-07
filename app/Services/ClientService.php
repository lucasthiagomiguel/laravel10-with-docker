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

        $client = $this->clientRepository->find($id);

        if (!$client) {
            throw new \Exception('Client not found.');
        }


        $client->update($data);
        return $client;
    }


    public function getClientById($id)
    {
       
        $client = $this->clientRepository->find($id);

        if (!$client) {
            throw new \Exception('Client not found.');
        }

        return $this->clientRepository->find($id);
    }

    public function deleteClient($id)
    {
        return $this->clientRepository->delete($id);
    }
}
