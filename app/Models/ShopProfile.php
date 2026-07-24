<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProfile extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'address',
        'phone',
        'receipt_footer',
        'tax_percentage',
        'service_charge_percentage',
        'primary_color',
        'sidebar_color',
        'sidebar_text_mode',
        'body_color',
    ];
}