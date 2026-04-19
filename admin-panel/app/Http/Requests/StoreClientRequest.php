<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $clientId = $this->route('client')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'client_access_code' => ['required', 'string', 'max:255', Rule::unique('clients', 'client_access_code')->ignore($clientId)],
            'url' => ['nullable', 'string', 'max:500'],
            'status' => ['nullable', 'in:active,trial,suspended'],
            'plan' => ['nullable', 'in:small,medium,large'],
            'users' => ['nullable', 'integer', 'min:0'],
            'user_limit' => ['nullable', 'integer', 'min:0'],
            'mrr' => ['nullable', 'numeric', 'min:0'],
            'vertical' => ['nullable', 'string', 'max:255'],
            'business_type' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'primary_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'accent_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'logo_url' => ['nullable', 'string', 'max:500'],
            'pos_api_base_url' => ['nullable', 'string', 'max:500'],
            'feature_flags.advanced_reporting' => ['nullable', 'boolean'],
            'feature_flags.multi_outlet_support' => ['nullable', 'boolean'],
            'feature_flags.api_access' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $flags = array_merge([
            'advanced_reporting' => false,
            'multi_outlet_support' => false,
            'api_access' => false,
        ], (array) $this->input('feature_flags', []));

        $this->merge([
            'feature_flags' => [
                'advanced_reporting' => filter_var($flags['advanced_reporting'], FILTER_VALIDATE_BOOLEAN),
                'multi_outlet_support' => filter_var($flags['multi_outlet_support'], FILTER_VALIDATE_BOOLEAN),
                'api_access' => filter_var($flags['api_access'], FILTER_VALIDATE_BOOLEAN),
            ],
        ]);
    }
}
