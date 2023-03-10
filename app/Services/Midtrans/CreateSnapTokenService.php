<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getSnapToken()
    {
        $dataOrder = Cart::where('user_id', Auth::user()->id)
                                ->where('status', '<>', 'pending')
                                ->where('payments', null)->get();
                            
        $item_details = [];

        foreach($dataOrder as $item) {
            if($item->user_id == Auth::user()->id || $item->id == $this->order->cart_id) {
                $item_details[] = [
                    'id' => $this->order->uuid,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'name' => $item->product->name_prod
                ];
            }
        }

        $item_details[] = [
            'id' => $this->order->uuid,
            'price' => $this->order->harga_ongkir,
            'name' => 'Ongkos Kirim',
            'quantity' => 1
        ];

        $params = [
            'transaction_details' => [
                'order_id' => $this->order->uuid,
                'gross_amount' => $this->order->total_belanja + $this->order->harga_ongkir,
            ],
            'item_details' => $item_details,
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->number_phone,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
