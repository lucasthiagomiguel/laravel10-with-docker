<?php

namespace Tests\Unit\Repositories\Order;

use Tests\TestCase;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        // Instanciando o repositório de Order
        $this->orderRepository = new OrderRepository();
    }

    /** @test */
    public function it_can_get_all_orders()
    {
        // Criando Orders de exemplo
        Order::factory()->count(10)->create();

        $orders = $this->orderRepository->all();

        $this->assertEquals(10, $orders->count());
    }

    /** @test */
    public function it_can_find_order_by_id()
    {
        $order = Order::factory()->create();

        $foundOrder = $this->orderRepository->find($order->id);

        $this->assertNotNull($foundOrder);
        $this->assertEquals($order->id, $foundOrder->id);
    }

    /** @test */
    public function it_can_create_order()
    {
        $data = Order::factory()->make()->toArray();

        $order = $this->orderRepository->create($data);

        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }

    /** @test */
    public function it_can_update_order()
    {
        $order = Order::factory()->create();

        $data = ['code' => 'Updated Order Code'];

        $updatedOrder = $this->orderRepository->update($order->id, $data);
        $this->assertEquals('Updated Order Code', $updatedOrder->code);
    }

   /** @test */
    public function it_can_soft_delete_order()
    {

        $order = Order::factory()->create();


        $result = $this->orderRepository->delete($order->id);


        $this->assertSoftDeleted('orders', ['id' => $order->id]);


        $this->assertDatabaseHas('orders', ['id' => $order->id, 'deleted_at' => now()]);
    }

}
