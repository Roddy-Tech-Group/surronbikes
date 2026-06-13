<x-mail::message>
# Payment Rejected

Hi {{ $order->customer_name }},

Unfortunately, we were unable to verify the payment for your order **{{ $order->order_number }}**. Your order has been cancelled.

**Reason for rejection:**
<x-mail::panel>
{{ $reason }}
</x-mail::panel>

If you believe this is a mistake, or if you would like to try placing a new order with a different payment method, please visit our store again.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
