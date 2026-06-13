<x-mail::message>
# Order Received

Hi {{ $order->customer_name }},

Thank you for your order! We have received it and it is currently **{{ $order->status_label }}**. 

Your Order Number is: **{{ $order->order_number }}**

### Order Summary

<x-mail::table>
| Product       | Quantity         | Price  |
| ------------- |:-------------:| --------:|
@foreach($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | ${{ number_format($item->product_price, 2) }} |
@endforeach
| **Total** | | **{{ $order->formatted_total }}** |
</x-mail::table>

**Payment Method:** {{ $order->paymentMethod->name ?? 'Unknown' }}

@if($order->paymentMethod && !empty($order->paymentMethod->details))
### Payment Instructions

Please send the exact amount of **{{ $order->formatted_total }}** using the details below:

@if($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_BANK)
* **Bank Name:** {{ $order->paymentMethod->details['bank_name'] }}
* **Account Name:** {{ $order->paymentMethod->details['account_name'] }}
* **Account Number:** `{{ $order->paymentMethod->details['account_number'] }}`
* **Routing / Sort Code:** `{{ $order->paymentMethod->details['routing_number'] }}`
@elseif($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_CRYPTO)
* **Network:** {{ $order->paymentMethod->details['network'] }}
* **Wallet Address:** `{{ $order->paymentMethod->details['wallet_address'] }}`
@elseif($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_ZELLE)
* **Zelle Email / Phone:** `{{ $order->paymentMethod->details['email_or_phone'] }}`
* **Account Name:** {{ $order->paymentMethod->details['account_name'] }}
@elseif($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_CASHAPP)
* **CashTag:** `{{ $order->paymentMethod->details['cashtag'] }}`
@elseif($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_PAYPAL)
* **PayPal Email:** `{{ $order->paymentMethod->details['email'] }}`
@elseif($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_MOBILE_MONEY)
* **Provider:** {{ $order->paymentMethod->details['provider'] }}
* **Phone Number:** `{{ $order->paymentMethod->details['phone_number'] }}`
* **Account Name:** {{ $order->paymentMethod->details['account_name'] }}
@endif

@if(!empty($order->paymentMethod->instructions))
**Additional Details:**
{!! strip_tags($order->paymentMethod->instructions) !!}
@endif

---
@endif

If your payment method requires manual transfer, please ensure you send the funds and upload your payment proof to process the order.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
