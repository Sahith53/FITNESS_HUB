<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'phone', 'address', 'city', 'state', 'zip_code', 'amount', 'status', 'payment_mode'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orders() {
        return $this->hasMany(OrderedProduct::class, 'order_id', 'id');
    }
}
