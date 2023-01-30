<?php

namespace App\Models;

// use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Uuid as Traits;
use App\Models\Cart;
use App\Models\User;

class Order extends Model
{
    use HasFactory, Traits;
    protected $guarded = ['id'];
    // protected $with = ['cart'];
    protected $table = 'orders';

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
