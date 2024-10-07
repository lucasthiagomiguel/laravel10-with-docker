<?php

namespace Tests\Unit\Repositories\Product;

use Tests\TestCase;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase; // Use esta trait para usar um banco de dados de teste

    protected ProductRepository $productRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = new ProductRepository();
    }

    /** @test */
    public function it_can_get_all_products()
    {
        // Arrange
        Product::factory()->count(3)->create();

        // Act
        $products = $this->productRepository->all();

        // Assert
        $this->assertCount(3, $products);
    }

    /** @test */
    public function it_can_find_a_product_by_id()
    {
        // Arrange
        $product = Product::factory()->create();

        // Act
        $foundProduct = $this->productRepository->find($product->id);

        // Assert
        $this->assertEquals($product->id, $foundProduct->id);
    }

    /** @test */
    public function it_can_create_a_product()
    {
        // Arrange
        $data = [
            'name' => 'New Product',
            'price' => 10.00,
            'photo' => 'path/to/photo.jpg', // Adicione um caminho de foto válido
        ];

        // Act
        $createdProduct = $this->productRepository->create($data);

        // Assert
        $this->assertEquals($data['name'], $createdProduct->name);
        $this->assertEquals($data['price'], $createdProduct->price);
        $this->assertEquals($data['photo'], $createdProduct->photo); // Verifica se a foto foi salva
    }


    /** @test */
    public function it_can_update_a_product()
    {
        // Arrange
        $product = Product::factory()->create();
        $data = ['name' => 'Updated Product', 'price' => 20.00];

        // Act
        $updatedProduct = $this->productRepository->update($product->id, $data);

        // Assert
        $this->assertEquals('Updated Product', $updatedProduct->name);
        $this->assertEquals(20.00, $updatedProduct->price);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        // Arrange
        $product = Product::factory()->create();

        // Act
        $deletedCount = $this->productRepository->delete($product->id);

        // Assert
        $this->assertEquals(1, $deletedCount);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function it_can_check_if_product_exists_by_name_and_different_id()
    {
        // Arrange
        $product = Product::factory()->create(['name' => 'Unique Product']);

        // Act
        $exists = $this->productRepository->findProductByNameById('Unique Product', $product->id);

        // Assert
        $this->assertFalse($exists);

        // Act with a different product
        $newProduct = Product::factory()->create(['name' => 'Unique Product']);

        // Act
        $exists = $this->productRepository->findProductByNameById('Unique Product', $product->id);

        // Assert
        $this->assertTrue($exists);
    }

    /** @test */
    public function it_can_check_if_product_exists_by_name()
    {
        // Arrange
        Product::factory()->create(['name' => 'Existing Product']);

        // Act
        $exists = $this->productRepository->findProductByName('Existing Product');

        // Assert
        $this->assertTrue($exists);

        // Act
        $exists = $this->productRepository->findProductByName('Non Existing Product');

        // Assert
        $this->assertFalse($exists);
    }
}
