<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Customer\PaymentApproved;
use App\Mail\Customer\PaymentRejected;
use App\Mail\Customer\OrderStatusUpdated;

class OrderService
{
    /**
     * The valid state transitions.
     * key: current status
     * values: array of allowed next statuses
     */
    protected const VALID_TRANSITIONS = [
        Order::STATUS_PENDING_VERIFICATION => [
            Order::STATUS_PAYMENT_CONFIRMED,
            Order::STATUS_CANCELLED,
        ],
        Order::STATUS_PAYMENT_CONFIRMED => [
            Order::STATUS_PROCESSING,
            Order::STATUS_CANCELLED,
        ],
        Order::STATUS_PROCESSING => [
            Order::STATUS_SHIPPED,
            Order::STATUS_CANCELLED,
        ],
        Order::STATUS_SHIPPED => [
            Order::STATUS_DELIVERED,
        ],
        Order::STATUS_DELIVERED => [],
        Order::STATUS_CANCELLED => [],
    ];

    /**
     * Get allowed next statuses for a given status.
     */
    public function getAllowedTransitions(string $currentStatus): array
    {
        return self::VALID_TRANSITIONS[$currentStatus] ?? [];
    }

    /**
     * Check if a transition is valid.
     */
    public function isValidTransition(string $currentStatus, string $newStatus): bool
    {
        return in_array($newStatus, $this->getAllowedTransitions($currentStatus));
    }

    /**
     * Approve a payment.
     * Transitions from PENDING_VERIFICATION to PAYMENT_CONFIRMED.
     */
    public function approvePayment(Order $order, Admin $admin): Order
    {
        if ($order->status !== Order::STATUS_PENDING_VERIFICATION) {
            throw new \Exception('Only pending orders can be approved.');
        }

        return DB::transaction(function () use ($order, $admin) {
            $previousStatus = $order->status;
            $newStatus = Order::STATUS_PAYMENT_CONFIRMED;

            $order->update(['status' => $newStatus]);

            $this->logHistory($order, $admin, $previousStatus, $newStatus);

            Mail::to($order->customer_email)->send(new PaymentApproved($order));

            return $order;
        });
    }

    /**
     * Reject a payment.
     * Transitions from PENDING_VERIFICATION to CANCELLED.
     */
    public function rejectPayment(Order $order, Admin $admin, string $reason): Order
    {
        if ($order->status !== Order::STATUS_PENDING_VERIFICATION) {
            throw new \Exception('Only pending orders can be rejected.');
        }

        return DB::transaction(function () use ($order, $admin, $reason) {
            $previousStatus = $order->status;
            $newStatus = Order::STATUS_CANCELLED;

            $order->update(['status' => $newStatus]);

            $this->logHistory($order, $admin, $previousStatus, $newStatus, $reason);

            Mail::to($order->customer_email)->send(new PaymentRejected($order, $reason));

            return $order;
        });
    }

    /**
     * Update the status of an order.
     * Used for general progression (Processing -> Shipped -> Delivered).
     */
    public function updateStatus(Order $order, Admin $admin, string $newStatus): Order
    {
        $previousStatus = $order->status;

        if (!$this->isValidTransition($previousStatus, $newStatus)) {
            throw new \Exception("Invalid status transition from {$previousStatus} to {$newStatus}.");
        }

        return DB::transaction(function () use ($order, $admin, $previousStatus, $newStatus) {
            $order->update(['status' => $newStatus]);

            $this->logHistory($order, $admin, $previousStatus, $newStatus);

            Mail::to($order->customer_email)->send(new OrderStatusUpdated($order));

            return $order;
        });
    }

    /**
     * Log the status change in the history table.
     */
    protected function logHistory(Order $order, ?Admin $admin, string $previousStatus, string $newStatus, ?string $reason = null): void
    {
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'admin_id' => $admin?->id,
            'previous_status' => $previousStatus,
            'new_status' => $newStatus,
            'reason' => $reason,
        ]);
    }
}
