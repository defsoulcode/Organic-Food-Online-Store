<?php

namespace App\Http\Controllers;

use App\Models\ReviewRating;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Result = [
            "product" => Product::with('ReviewData')->first()
        ];

        $data = $Result['product']->all()->map(function ($query) {
            $dataRatings = ReviewRating::where('id_product', '=', $query->id)->get();
            if ($dataRatings->count() == 0) {
                $query->star_rating = 0;
            } else {
                $rating = $dataRatings->sum('star_rating') / $dataRatings->count();
                $query->star_rating = $rating;
            }
            return $query;
        });

        $data = $data->filter(function ($product) {
            return $product->star_rating >= 1;
        });

        $rating = ReviewRating::select('id')->get(['id']);
        // foreach($rating as $r){
        //     $r->id;
        // }

        // dd($rating);
        
        return view('pages.admin.adminReviews.index', compact('data', 'rating'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', '=', $id)->get(['image', 'detail', 'name_prod']);
        $userRating = ReviewRating::with('user')->where('id_product', '=', $id)->where('id_user', '<>', 1)->get(['star_rating', 'comments', 'id_user']);

        return view('pages.admin.adminReviews.show', compact('product', 'userRating'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = ReviewRating::where('id_product', '=', $id);
        $review->delete();
        return redirect()->route('admin-reviews.index')->with('errors', 'Review successfully deleted!');
    }
}
