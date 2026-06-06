<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'code', 'user_id', 'customer', 'phone', 'address',
        'service', 'items', 'total', 'pickup_date', 'pickup_time',
        'status', 'payment_status', 'paid_at',
    ];

    protected $casts = [
        'items' => 'array',
        'total' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
