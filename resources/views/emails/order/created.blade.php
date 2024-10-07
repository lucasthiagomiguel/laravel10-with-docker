@component('mail::message')
# Order #{{ $order->code }}

Hello {{ $client->name }},

Your order has been successfully created on {{ $order->created_at->format('d/m/Y H:i') }}. Here are the details:

## Products

@component('mail::table')
| Product       | Amount | Unit Price | Total       |
| ------------- |:----------:| --------------:| -----------:|
@foreach ($products as $product)
| {{ $product->name }} | {{ $product->pivot->quantity }} | R$ {{ number_format($product->price, 2, ',', '.') }} | R$ {{ number_format($product->price * $product->pivot->quantity, 2, ',', '.') }} |
@endforeach
@endcomponent

## Order Total: R$ {{ number_format($order->products->sum(function($product) { return $product->price * $product->pivot->quantity; }), 2, ',', '.') }}

Thank you for choosing our bakery!

Yours sincerely,<br>
{{ config('app.name') }}
@endcomponent
