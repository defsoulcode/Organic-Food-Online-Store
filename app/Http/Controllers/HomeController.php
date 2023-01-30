<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Distribut;
use App\Models\ReviewRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $tag = '';
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $tag = ' category: ' . $category->name;
        }

        if(request('distribut')) {
            $distribut = Distribut::firstWhere('slug', request('distribut'));
            $tag = ' distribut: ' . $distribut->name_distr;
        }


        return view('pages.home', [
            "tag" => $tag,
            "data" => Product::latest()->filter(request(['search', 'category', 'distribut']))->paginate(9)->withQueryString(),
        ]);
    }

    public function info($id)
    {
        $idProduct = Product::findOrFail($id);
        $reviews = ReviewRating::where([
                        ['id_product', '=', $id],
                        ['id_user', Auth::user()->id]
                    ])->get();

        return view('pages.homeInfoProduct', [
            "info" => $idProduct,
            "reviews" => $reviews,
        ]);
    }

    public function reviewRating(Request $request)
    {
        $reviews = ReviewRating::where('id_user', Auth::user()->id)
                                ->where('id_product', $request->id_product)->first();

        if($reviews !== null) {
            $reviews->update([
                'comments' => $request->comment,
                'star_rating' => $request->rating
            ]);
            return redirect()->back()->with('success', 'Rating updated successfully!');
        } else {
            $reviews = ReviewRating::create([
                'id_product' => $request->id_product,
                'id_user' => Auth::user()->id,
                'comments' => $request->comment,
                'star_rating' => $request->rating
            ]);

            return redirect()->back()->with('success', 'Rating added successfully!');
        }
    }
}
