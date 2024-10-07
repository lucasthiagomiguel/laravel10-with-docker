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

    public function createProducts(array $data)
    {

        if (isset($data['photo'])) {
            $imagePath = $this->uploadPhoto($data['photo']);
            $data['photo'] = $imagePath;
        }

        $product = $this->productRepository->create($data);

        $product->photo = asset('storage/' . $product->photo);

        return $product;


    }


    public function updateProducts($id, array $data)
    {
        // Check if the product exists
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw new \Exception('Product not found.');
        }

        // If the photo is uploaded, upload it and update the path
        if (isset($data['photo'])) {
            $imagePath = $this->uploadPhoto($data['photo']);
            $data['photo'] = $imagePath; // Atualiza o caminho da nova imagem
        }

        // Updates product data (including image path if updated)
        $product->update($data);

        // Returns the product with the full URL of the photo (either new or old)
        $product->photo = url('storage/' . $product->photo);

        return $product;
    }




    public function getProductsById($id)
    {
        return $this->productRepository->find($id);
    }

    public function deleteProducts($id)
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw new \Exception('Product not found.');
        }
        return $this->productRepository->delete($id);
    }

    private function uploadPhoto($photo)
    {
        // Save the image in the 'products' folder inside 'storage/app/public'
        $path = $photo->store('products', 'public');

        return $path;
    }


}
