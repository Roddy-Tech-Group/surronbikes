<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    public function index(): View
    {
        $paymentMethods = PaymentMethod::latest()->get();
        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    public function create(): View
    {
        $types = PaymentMethod::TYPES;
        return view('admin.payment-methods.create', compact('types'));
    }

    public function store(PaymentMethodRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');
        $validated['instructions'] = $validated['instructions'] ?? '';

        PaymentMethod::create($validated);

        return redirect()
            ->route('admin.payment-methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    public function edit(PaymentMethod $paymentMethod): View
    {
        $types = PaymentMethod::TYPES;
        return view('admin.payment-methods.edit', compact('paymentMethod', 'types'));
    }

    public function update(PaymentMethodRequest $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');
        $validated['instructions'] = $validated['instructions'] ?? '';

        $paymentMethod->update($validated);

        return redirect()
            ->route('admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        $hasOrders = \App\Models\Order::where('payment_method_id', $paymentMethod->id)->exists();
        
        if ($hasOrders) {
            return back()->with('error', 'Cannot delete this payment method because it is referenced by existing orders. Consider deactivating it instead.');
        }

        $paymentMethod->delete();

        return redirect()
            ->route('admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }

    public function toggleActive(PaymentMethod $paymentMethod): RedirectResponse
    {
        $paymentMethod->update(['is_active' => !$paymentMethod->is_active]);

        $status = $paymentMethod->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Payment method has been {$status}.");
    }
}
