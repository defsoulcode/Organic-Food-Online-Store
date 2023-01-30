<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ReviewRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BestSellerController extends Controller
{
    public function bestSellerProducts(Request $request)
    {
        #get nilai harga minus & harga max dari table harga
        $harga_min = Product::min('price');
        $harga_max = Product::max('price');

        #Get filter request parameters & set value
        $filter_harga_min = $request->harga_min;
        $filter_harga_max = $request->harga_max;

        #data product ketika di filter
        if ($filter_harga_min && $filter_harga_max) {
            if ($filter_harga_min > 0 && $filter_harga_max > 0) {
                $products = Product::select('name_prod', 'price','image', 'id')
                                ->whereBetween('price', [$filter_harga_min, $filter_harga_max])
                                    ->orderBy('id', 'Desc')->get();
    
                $products = $products->map(function($product) {
                    $productRatings = ReviewRating::where('id_product', '=', $product->id)->get();
                    if($productRatings->count() == 0) {
                        $product->star_rating = 0;
                    } else {
                        $rating = $productRatings->sum('star_rating') / $productRatings->count();
                        $product->star_rating = $rating;
                    }
                    return $product;
                });

                $bestProducts = $products->filter(function($product) {
                    return $product->star_rating >= 4;
                });
            }
            #tampilkan semuanya jika user tidak filter
        } else {
            $products = Product::with('user')->latest()->get();

            $products = $products->map(function ($product) {
                $productRatings = ReviewRating::where('id_product', '=', $product->id)->get();
                if ($productRatings->count() == 0) {
                    $product->star_rating = 0;
                } else {
                    $rating = $productRatings->sum('star_rating') / $productRatings->count();
                    $product->star_rating = $rating;
                }
                return $product;
            });

            $bestProducts = $products->filter(function ($product) {
                return $product->star_rating >= 4;
            });
        }

        return view('pages.bestSeller', [
            'products' => $bestProducts,
            'harga_min' => $harga_min,
            'harga_max' => $harga_max,
            'filter_harga_min' => $filter_harga_min,
            'filter_harga_max' => $filter_harga_max,
        ]);
    }
}