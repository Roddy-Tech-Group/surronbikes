<?php

namespace App\Http\Requests\Admin;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:' . implode(',', array_keys(PaymentMethod::TYPES))],
            'instructions' => ['nullable', 'string'],
        ];

        // Dynamic validation based on selected type
        $type = $this->input('type');
        
        if ($type === PaymentMethod::TYPE_BANK) {
            $rules['details.bank_name'] = ['required', 'string', 'max:255'];
            $rules['details.account_name'] = ['required', 'string', 'max:255'];
            $rules['details.account_number'] = ['required', 'string', 'max:255'];
            $rules['details.routing_number'] = ['required', 'string', 'max:255'];
        } 
        elseif ($type === PaymentMethod::TYPE_CRYPTO) {
            $rules['details.network'] = ['required', 'string', 'max:255'];
            $rules['details.wallet_address'] = ['required', 'string', 'max:255'];
        }
        elseif ($type === PaymentMethod::TYPE_ZELLE) {
            $rules['details.account_name'] = ['required', 'string', 'max:255'];
            $rules['details.email_or_phone'] = ['required', 'string', 'max:255'];
        }
        elseif ($type === PaymentMethod::TYPE_CASHAPP) {
            $rules['details.cashtag'] = ['required', 'string', 'max:255'];
        }
        elseif ($type === PaymentMethod::TYPE_PAYPAL) {
            $rules['details.email'] = ['required', 'email', 'max:255'];
        }
        elseif ($type === PaymentMethod::TYPE_MOBILE_MONEY) {
            $rules['details.provider'] = ['required', 'string', 'max:255'];
            $rules['details.phone_number'] = ['required', 'string', 'max:255'];
            $rules['details.account_name'] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'details.bank_name.required' => 'Bank Name is required for Bank Transfer.',
            'details.account_name.required' => 'Account Name is required.',
            'details.account_number.required' => 'Account Number is required.',
            'details.routing_number.required' => 'Routing/Sort Code is required.',
            'details.network.required' => 'Network (e.g. BTC, ERC20) is required for Crypto.',
            'details.wallet_address.required' => 'Wallet Address is required for Crypto.',
            'details.email_or_phone.required' => 'Email or Phone is required for Zelle.',
            'details.cashtag.required' => 'CashTag is required for CashApp.',
            'details.email.required' => 'Email is required for PayPal.',
            'details.provider.required' => 'Provider name is required for Mobile Money.',
            'details.phone_number.required' => 'Phone number is required for Mobile Money.',
        ];
    }
}
