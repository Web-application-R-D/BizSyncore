<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'address',
        'company_name',
        'website',
        'email',
        'phone',
        'client_access_code',
        'url',
        'status',
        'plan',
        'users',
        'user_limit',
        'mrr',
        'joined_at',
        'vertical',
        'business_type',
        'country',
        'display_name',
        'primary_color',
        'accent_color',
        'logo_url',
        'pos_api_base_url',
        'feature_flags',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'mrr' => 'decimal:2',
        'feature_flags' => 'array',
    ];
}
