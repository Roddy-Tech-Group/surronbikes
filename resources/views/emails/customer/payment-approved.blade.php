<x-mail::message>
# Payment Confirmed

Hi {{ $order->customer_name }},

Great news! We have successfully received and verified your payment for order **{{ $order->order_number }}**.

Your order status has been updated to **Payment Confirmed**. We will begin processing your order right away and will notify you as soon as it ships.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
