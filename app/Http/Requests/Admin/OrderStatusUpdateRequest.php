<?php

namespace App\Http\Requests\Admin;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class OrderStatusUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(Order::STATUSES))],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $order = $this->route('order');
                $newStatus = $this->input('status');
                
                if (!$order || !$newStatus) {
                    return;
                }

                $orderService = app(OrderService::class);
                
                if (!$orderService->isValidTransition($order->status, $newStatus)) {
                    $validator->errors()->add(
                        'status',
                        "Invalid status transition from '{$order->status_label}' to '" . (Order::STATUSES[$newStatus] ?? $newStatus) . "'."
                    );
                }
            }
        ];
    }
}
