<?php

namespace App\Repositories\Product;


use App\Models\Product;

class ProductRepository
{
    public function all()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $Product = Product::findOrFail($id); // Use findOrFail to throw exception if not found
        $Product->update($data);
        return $Product;
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }

    public function findProductByNameById($name, $ProductId)
    {
        return Product::where('name', $name)
        ->where('id', '!=', $ProductId) // Não considera o Producte atual
        ->exists();
    }

    public function findProductByName($name)
    {
        return Product::where('name', $name)
        ->exists();
    }

}
