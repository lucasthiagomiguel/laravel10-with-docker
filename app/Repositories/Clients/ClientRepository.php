<?php

namespace App\Repositories\Clients;

use App\Models\Client;

class ClientRepository
{
    public function all()
    {
        return Client::all();
    }

    public function find($id)
    {
        return Client::find($id);
    }

    public function create(array $data)
    {
        return Client::create($data);
    }

    public function update($id, array $data)
    {
        $client = Client::findOrFail($id); // Use findOrFail to throw exception if not found
        $client->update($data);
        return $client;
    }

    public function delete($id)
    {
        return Client::destroy($id);
    }

    public function findClientByEmail($email, $clientId)
    {
        return Client::where('email', $email)
        ->where('id', '!=', $clientId) // Não considera o cliente atual
        ->exists();
    }

}
