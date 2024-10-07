<?php

namespace App\Services\Products;

use App\Repositories\Product\ProductRepository;

class ProductsService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    public function createProduct(array $data)
    {
        if (isset($data['photo'])) {
            $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        $product = $this->productRepository->create($data);
        $product->photo = asset('storage/' . $product->photo);
        return $product;
    }

    public function updateProduct($id, array $data)
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw new \Exception('Product not found.');
        }

        if (isset($data['photo'])) {
            $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        $this->productRepository->update($id, $data);

        return (object) array_merge((array) $product, $data);
    }



    public function getProductById($id)
    {
        return $this->productRepository->find($id);
    }

    public function deleteProduct($id)
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw new \Exception('Product not found.');
        }
        return $this->productRepository->delete($id);
    }

    private function uploadPhoto($photo)
    {

        return $photo->store('products', 'public');
    }
}
