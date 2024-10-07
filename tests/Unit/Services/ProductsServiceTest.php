<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use Tests\TestCase;
use App\Services\Products\ProductsService;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class ProductsServiceTest extends TestCase
{
    protected ProductRepository $productRepository;
    protected ProductsService $productsService;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = Mockery::mock(ProductRepository::class);
        $this->productsService = new ProductsService($this->productRepository);
        Storage::fake('public');
    }

    /** @test */
    public function it_can_get_all_products()
    {
        $this->productRepository->shouldReceive('all')->once()->andReturn([]);

        $products = $this->productsService->getAllProducts();

        $this->assertIsArray($products);
    }

    /** @test */
    public function it_can_create_product_with_photo()
    {
        // Arrange
        $photo = UploadedFile::fake()->image('new_photo.jpg');
        $data = [
            'name' => 'Product 1',
            'price' => 10,
            'photo' => $photo,
        ];

        // Mock do produto
        $mockProduct = new Product();
        $mockProduct->id = 1;
        $mockProduct->name = $data['name'];
        $mockProduct->price = $data['price'];
        $mockProduct->photo = 'products/new_photo.jpg';

       
        $this->productRepository->shouldReceive('create')->once()->with(Mockery::on(function ($arg) {
            return $arg['name'] === 'Product 1' && $arg['price'] === 10 && isset($arg['photo']);
        }))->andReturn($mockProduct);

        // Act
        $product = $this->productsService->createProduct($data);

        // Assert
        $this->assertEquals($data['name'], $product->name);
        $this->assertEquals($data['price'], $product->price);
        $this->assertEquals(asset('storage/products/new_photo.jpg'), $product->photo); // Verifique o caminho correto
    }

    /** @test */
    public function it_can_update_product_with_photo()
    {
        // Arrange
        $photo = UploadedFile::fake()->image('new_photo.jpg');
        $data = [
            'name' => 'Updated Product',
            'price' => 20,
            'photo' => $photo,
        ];

        $mockProduct = new Product();
        $mockProduct->id = 1;
        $mockProduct->name = 'Old Product';
        $mockProduct->price = 10;
        $mockProduct->photo = 'products/old_photo.jpg';


        $this->productRepository->shouldReceive('find')->once()->with(1)->andReturn($mockProduct);


        $this->productRepository->shouldReceive('update')
            ->once()
            ->with(1, Mockery::on(function ($arg) {
                return $arg['name'] === 'Updated Product' && $arg['price'] === 20 && isset($arg['photo']);
            }))
            ->andReturn((object) [
                'id' => 1,
                'name' => 'Updated Product',
                'price' => 20,
                'photo' => 'products/new_photo.jpg',
            ]);

        // Act
        $product = $this->productsService->updateProduct(1, $data);

        // Assert
        $this->assertEquals($data['name'], $product->name);
        $this->assertEquals($data['price'], $product->price);
        $this->assertEquals(asset('storage/products/new_photo.jpg'), $product->photo);

    }


    /** @test */
    public function it_can_get_product_by_id()
    {
        // Arrange
        $id = 1;
        $mockProduct = new Product();
        $mockProduct->id = $id;
        $mockProduct->name = 'Product 1';
        $mockProduct->price = 10;
        $mockProduct->photo = 'products/photo.jpg';

        $this->productRepository->shouldReceive('find')->once()->with($id)->andReturn($mockProduct);

        // Act
        $product = $this->productsService->getProductById($id);

        // Assert
        $this->assertEquals($id, $product->id);
        $this->assertEquals('Product 1', $product->name);
        $this->assertEquals(10, $product->price);
    }

    /** @test */
    public function it_can_delete_product()
    {
        $id = 1;


        $productMock = new Product();
        $productMock->id = $id;


        $this->productRepository->shouldReceive('find')->once()->with($id)->andReturn($productMock);
        $this->productRepository->shouldReceive('delete')->once()->with($id)->andReturn(true);

        $result = $this->productsService->deleteProduct($id);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_throws_exception_when_product_not_found_on_delete()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Product not found.');

        $id = 1;


        $this->productRepository->shouldReceive('find')->once()->with($id)->andReturn(null);

        $this->productsService->deleteProduct($id);
}
