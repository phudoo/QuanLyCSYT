<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersReport extends Model
{
    protected $fillable = [
        'order_id',
        'total_revenue',
        'total_cost',
        'total_profit'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
