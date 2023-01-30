<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Distribut;
use App\Models\User;
use App\Models\ReviewRating;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $reviewsRating = ReviewRating::all();
        $product = Product::all();
        $distribut = Distribut::all();
        $category = Category::all();
        $users = User::where('status_type', '<>', 1)->get();
        
        $labels1 = ['Product', 'Distribut'];
        $labels2 = ['Rating', 'Categories', 'Users'];

        $data1 = [
            $product->count(), 
            $distribut->count(),
        ];

        $data2 = [
            $reviewsRating->count(),
            $category->count(),
            $users->count()
        ];
        
        return view('pages.admin.index', 
            compact(
                    'reviewsRating',
                    'product', 
                    'distribut',  
                    'category',
                    'users',
                    'labels1',
                    'data1',
                    'labels2',
                    'data2',
                ));
    }
}
