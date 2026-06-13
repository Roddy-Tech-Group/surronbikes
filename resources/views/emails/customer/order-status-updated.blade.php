<x-mail::message>
# Order Status Updated

Hi {{ $order->customer_name }},

The status of your order **{{ $order->order_number }}** has been updated to: **{{ $order->status_label }}**.

@if($order->status === \App\Models\Order::STATUS_SHIPPED)
Your order is now on its way to you! 
@elseif($order->status === \App\Models\Order::STATUS_DELIVERED)
Your order has been marked as delivered. We hope you enjoy your purchase!
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
