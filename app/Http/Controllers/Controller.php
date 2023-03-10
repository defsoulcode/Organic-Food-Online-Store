<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()) {
                $cart = Cart::where('user_id', auth()->user()->id)
                                        ->where('status', '=', 'pending')->get();
                View::share('cart', $cart);
            }

            return $next($request);
        });
    }
}
