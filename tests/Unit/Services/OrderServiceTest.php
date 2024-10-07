<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\Order\OrderService;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Clients\ClientRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use App\Models\Order; 
use Mockery;

class OrderServiceTest extends TestCase
{
    protected OrderRepository $orderRepository;
    protected ClientRepository $clientRepository;
    protected OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();


        $this->orderRepository = Mockery::mock(OrderRepository::class);
        $this->clientRepository = Mockery::mock(ClientRepository::class);


        $this->orderService = new OrderService($this->orderRepository, $this->clientRepository);


        Mail::fake();
    }

    /** @test */
    public function it_can_create_order()
    {
        $data = [
            'client_id' => 1,
            'products' => [
                ['product_id' => 1, 'quantity' => 2],
                ['product_id' => 2, 'quantity' => 1],
            ],
        ];


        $clientMock = Mockery::mock();
        $clientMock->email = 'client@example.com';


        $this->clientRepository->shouldReceive('find')
            ->once()
            ->with($data['client_id'])
            ->andReturn($clientMock);


        $order = new Order();
        $order->id = 1;
        $order->client_id = $data['client_id'];


        $orderMock = Mockery::mock($order);
        $orderMock->shouldReceive('products')->andReturnSelf();
        $orderMock->shouldReceive('attach')->once()->with(1, ['quantity' => 2]);
        $orderMock->shouldReceive('attach')->once()->with(2, ['quantity' => 1]);


        $this->orderRepository->shouldReceive('create')
            ->once()
            ->with(Mockery::type('array'))
            ->andReturn($orderMock);


        Mail::to($clientMock->email)->send(new OrderCreated($order));

        $order = $this->orderService->createOrder($data);

        $this->assertEquals(1, $order->id);
        $this->assertEquals($data['client_id'], $order->client_id);


        Mail::assertSent(OrderCreated::class, function ($mail) use ($clientMock) {
            return $mail->hasTo($clientMock->email);
        });
    }

    /** @test */
    public function it_can_update_order()
    {
        $id = 1;
        $data = [
            'client_id' => 2,
            'products' => [
                ['product_id' => 1, 'quantity' => 3],
            ],
        ];


        $orderMock = Mockery::mock();
        $orderMock->shouldReceive('save')->once();
        $orderMock->shouldReceive('products')->andReturnSelf();
        $orderMock->shouldReceive('sync')->once();
        $orderMock->shouldReceive('load')->with(['client', 'products'])->andReturn($orderMock);


        $this->orderRepository->shouldReceive('find')->once()->with($id)->andReturn($orderMock);

        $updatedOrder = $this->orderService->updateOrder($id, $data);


        $this->assertEquals(2, $updatedOrder->client_id);
    }

    /** @test */
    public function it_can_delete_order()
    {
        $id = 1;

        $orderMock = Mockery::mock();

        $this->orderRepository->shouldReceive('find')->once()->with($id)->andReturn($orderMock);
        $this->orderRepository->shouldReceive('delete')->once()->with($id)->andReturn(true);

        $result = $this->orderService->deleteOrder($id);

        $this->assertTrue($result);
    }


    public function it_throws_exception_when_order_not_found_on_delete()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('order not found.');

        $id = 1;


        $this->orderRepository->shouldReceive('find')->once()->with($id)->andReturn(null);

        $this->orderService->deleteOrder($id);
    }
}
