<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'address',
    'company_name',
    'website',
    'email',
    'phone',
    'client_access_code',
    'url',
])]
class Client extends Model
{
}
