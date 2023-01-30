<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Distribut;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Product::join('distributs', 'distributs.id', '=', 'products.distribut_id')
                        ->join('categories', 'categories.id', '=', 'products.category_id')
                        ->orderBy('code_prod', 'ASC')
                        ->get([
                                'products.id',
                                'products.code_prod',
                                'products.name_prod',
                                'products.price',
                                'products.stock',
                                'products.image',
                                'distributs.name_distr',
                                'categories.name'
                            ]);

        return view('pages.admin.adminProduct.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $results = [
            'categories' => Category::select('id', 'name')->get(),
            'distributs' => Distribut::select('id', 'name_distr')->get()
        ];

        // dd($results);
        return view('pages.admin.adminProduct.create', $results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_prod' => 'required|max:255|unique:products',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|max:150',
            'distribut_id' => 'required|max:150',
            'image' => 'required|image|file|max:1024',
            'detail' => 'required',
            'weight' => 'required|numeric'
        ]);

        $kodeDepan = strtoupper(substr($request->name_prod, 0, 1));
        $data = Product::where('name_prod', 'like', $kodeDepan . '%')->orderBy('id', 'DESC')->first();

        if ($data) {
            $old = ltrim($data->code_prod, $kodeDepan);
            $number = $old + 1;
            if ($number < 10) {
                $nol = '000';
            } elseif ($number < 1000) {
                $nol = '00';
            } elseif ($number < 100) {
                $nol = '0';
            } else {
                $nol = '';
            }
            $fixKode = $kodeDepan . $nol . $number;
        } else {
            $fixKode = $kodeDepan . '0001';
        }

        $validateData = [
            'code_prod' => $fixKode,
            'name_prod' => $request->name_prod,
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'category_id' => $request->category_id,
            'distribut_id' => $request->distribut_id,
            'detail' => $request->detail,
            'weight' => $request->weight
        ];

        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->store('uploaded-product');
        }

        $validateData['excerpt'] = Str::limit(strip_tags($request->detail), 50);
        
        if(!$validateData['price'] == 0) {
            $validateData['price'] = $request->price;
        } else {
            $validateData['price'] = 50000;
        }

        $product = Product::create($validateData);
        // dd($product);

        if ($product) {
            return redirect()->route('product.index')->with('success', 'Product added successfully');
        } else {
            return redirect()->route('product.index')->with('errors', 'Product failed to add');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas = [
            'product' => Product::findOrFail($id),
            'categories' => Category::select('id', 'name')->get(),
            'distributs' => Distribut::select('id', 'name_distr')->get()
        ];
        // dd($datas);
        return view('pages.admin.adminProduct.show', compact('datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $results = [
            'product' => Product::findOrFail($id),
            'categories' => Category::select('id', 'name')->get(),
            'distributs' => Distribut::select('id', 'name_distr')->get()
        ];

        // dd($results);
        return view('pages.admin.adminProduct.edit', $results);
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
        $data = [
            'name_prod' => 'required|max:255|unique:products',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|max:150',
            'distribut_id' => 'required|max:150',
            'image' => 'image|file|max:1024',
            'detail' => 'required',
            'weight' => 'required|numeric'
        ];


        $validateData = $request->validate($data);

        if ($request->file('image')) {
            if ($request->oldCover) {
                Storage::delete($request->oldCover);
            }
            $validateData['image'] = $request->file('image')->store('uploaded-product');
        }

        $validateData['excerpt'] = Str::limit(strip_tags($request->detail), 50);

        $product = Product::find($id)->update($validateData);

        // dd($product);
        if ($product) {
            return redirect()->route('product.index')->with('success', 'Product successfully updated');
        } else {
            return redirect()->route('product.index')->with('errors', 'Product failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete($product->image);
        }

        Product::destroy($product->id);
        return redirect()->route('product.index')->with('errors', 'The product was successfully deleted');
    }
}
