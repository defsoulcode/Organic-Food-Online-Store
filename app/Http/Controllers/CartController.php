<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $result = Cart::where('user_id', Auth::user()->id)
                            ->where('status', '=', 'pending')->get();
        $total = 0;
        foreach ($result as $item) {
            if($item->quantity >= $item->product->stock) {
                $total += $item->product->stock * $item->product->price;
            } else {
                $total += $item->quantity *  $item->product->price;
            }
        }

        return view('pages.homeCart.index', compact('result', 'total'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
        ]);

        $allItem = Cart::with('product')->where('product_id', $request->product_id)->get();
        foreach ($allItem as $data) {
            if($data->quantity > $data->product->stock) {
                $data['quantity'] = $data->quantity;
                return redirect()->route('cart.index')->with('delete', 'Ups, You order more than the available stock');
            } else {
                $data->quantity;
            }
        }

        $item = Cart::where('product_id', $request->product_id)
                            ->where('user_id', auth()->user()->id)
                            ->where('status', '<>', 'settlement')->first();

        $data = Cart::where('product_id', $request->product_id)
                            ->where('user_id', auth()->user()->id)->get();
        if ($item) {
            $item->update(['quantity' => $item->quantity + 1]);
            $validatedData['user_id'] = auth()->user()->id;
            $validatedData['status'] = 'pending';
        } else {
            foreach ($data as $item_cart) {
                if($item_cart->product_id) {
                    $validatedData['user_id'] = auth()->user()->id;
                    $validatedData['quantity'] = $request->quantity;
                    $validatedData['status'] = 'pending';
                }
            }
            $validatedData['user_id'] = auth()->user()->id;
            $validatedData['quantity'] = $request->quantity;
            $validatedData['status'] = 'pending';
            Cart::create($validatedData);
        }
        return redirect()->route('cart.index')->with('success', 'Product added to Cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $datas = [
            'quantity' => $request->input('quantity'),
        ];

        Cart::findOrFail($id)->update($datas);

        return redirect()->route('cart.index')->with('success','Your product order has been successfully updated!');
    }

    public function remove($id)
    {
        Cart::destroy($id);
        return redirect()->route('cart.index')->with('delete', 'Your order product is removed from Cart!');
    }
}
