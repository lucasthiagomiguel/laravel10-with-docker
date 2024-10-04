<?php

namespace App\Http\Controllers;


use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return Client::all();
    }

    public function show($id)
    {
        return Client::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:clients',
        ]);

        return Client::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->all());
        return $client;
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return response(null, 204);
    }
}
