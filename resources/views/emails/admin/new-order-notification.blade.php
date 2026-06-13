<x-mail::message>
# New Order Notification

A new order has been placed on the store.

**Order Number:** {{ $order->order_number }}  
**Customer Name:** {{ $order->customer_name }}  
**Customer Email:** {{ $order->customer_email }}  
**Order Total:** {{ $order->formatted_total }}  
**Payment Method:** {{ $order->paymentMethod->name ?? 'Unknown' }}

<x-mail::button :url="route('admin.orders.show', $order)">
View Order Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
