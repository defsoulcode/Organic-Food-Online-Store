<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Cities;
use App\Models\Province;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Midtrans\CreateSnapTokenService;

class CheckoutController extends Controller
{
    public function getCity($id)
    {
        $cities = Cities::where('province_id', '=', $id)->select(['id', 'nama_kab_kota'])->get();
        return response()->json($cities);
    }

    public function getOngkir($destination, $weight, $courier)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=444&destination=$destination&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 91dd56b26cc7b9a58d9c1112b28d9244"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $data_ongkir = $response['rajaongkir']['results'];
            return json_encode($data_ongkir);
        }
    }

    public function create()
    {
        $totalBelanja = 0;
        $totalBerat = 0;
        $provinces = Province::all();
        $itemData = Cart::with('product')->where('user_id', Auth::user()->id)
                                            ->where('status', '=', 'pending')->get();
        foreach($itemData as $item) {
            $totalBerat += $item->product->weight * $item->quantity;
            $totalBelanja += $item->product->price * $item->quantity;
        }

        return view('pages.checkout.create', 
            compact('provinces', 'totalBerat', 'totalBelanja', 'itemData'));
    }
    
    public function store(Request $request) 
    {
        $validateData = $request->validate([
            'cart_id' => 'required|max:150',
            'province_id' => 'required|max:150',
            'destination_id' => 'required|max:150',
            'courier' => 'required|max:150',
            'weight' => 'required|numeric',
            'address' => 'required|max:150',
            'harga_ongkir' => 'required|numeric',
            'total_belanja' => 'required|numeric',
        ]);

        $dataCart = Cart::where('user_id', Auth::user()->id)
                                    ->where('status', '=', 'pending')
                                    ->get();
                                    
        foreach($dataCart as $data) {
            $data->update([
                'status' => 'settlement'
            ]);
            $data->product->update([
                'stock' => $data->product->stock - $data->quantity
            ]);
        }
        
        $order = Order::create($validateData);

        if ($order) {
            if (empty($validateData['snap_token'])) {
                $midtrans = new CreateSnapTokenService($order);
                $snapToken = $midtrans->getSnapToken();
                $order->update(['snap_token' => $snapToken]);
            }
            return redirect()->route('checkout.pembayaran')->with('success', 'Your order has been successfully added');
        } else {
            return redirect()->route('checkout.pembayaran')->with('errors', 'Your order failed to add');
        }
    }

    public function pembayaran()
    {
        // $dataValid = Order::where('user_id', '=', Auth::user()->id)->get();
        $dataValid = Order::all();
        $provinsi = 0;
        $snapToken = null;
        foreach ($dataValid as $item) {
            $snapToken = $item->snap_token;
            $provinsi = $item->province_id;
        }

        return view('pages.checkout.pembayaran', compact('snapToken', 'provinsi'));
    }

    public function konfirmasiPembayaran(Request $request)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $jsonOrder = json_decode($request->json);
        $dataOrder = [
            'transaction_id' => $jsonOrder->transaction_id,
            // 'status' => $jsonOrder->transaction_status,
            'payment_type' => $jsonOrder->payment_type,
            'payment_code' => isset($jsonOrder->payment_code) ? $jsonOrder->payment_code : null,
            // 'pdf_url' => isset($jsonOrder->pdf_url) ? $jsonOrder->pdf_url : null
        ];

        foreach($cart as $data ) {
            $data->update(['payments' => 'lunas']);
        }

        $order = Order::where('uuid', '=', $jsonOrder->order_id);
        if ($order) {
            $order->update($dataOrder);
        }

        // dd($order);

        if ($order) {
            return redirect()->route('checkout.pembayaran')->with('success', 'Your order has been successfully paid');
        } else {
            return redirect()->route('checkout.pembayaran')->with('errors', 'Your order failed to pay');
        }
    }


    

    public function confirm(Request $request)
    {
        
    }
}

    
    
