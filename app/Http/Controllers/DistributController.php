<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Distribut;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DistributController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.adminDistribut.index', [
            "distribut" => Distribut::orderBy('name_distr', 'ASC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.adminDistribut.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name_distr' => 'required|max:255',
            'slug' => 'required|unique:distributs',
            'image' => 'required|file|max:1024',
            'detail_distr' => 'required'
        ]);

        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->store('uploaded-distribut');
        }

        $validateData['excerpt'] = Str::limit(strip_tags($request->detail_distr), 50);

        $distribut = Distribut::create($validateData);

        if ($distribut) {
            return redirect()->route('distribut.index')->with('success', 'Distributor added successfully');
        } else {
            return redirect()->route('distribut.index')->with('errors', 'Distributor failed to add');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Distribut $distribut)
    {
        return view('pages.admin.adminDistribut.show', [
            'distribut' => $distribut
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editDistribut = Distribut::findOrFail($id);
        return view('pages.admin.adminDistribut.edit', [
            'distribut' => $editDistribut
        ]);
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
        $datas = [
            'name_distr' => 'required|max:255',
            'slug' => 'required|unique:distributs',
            'image' => 'image|file|max:1024',
            'detail_distr' => 'required'
        ];

        $validateData = $request->validate($datas);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('uploaded-distribut');
        }

        $validateData['excerpt'] = Str::limit(strip_tags($request->detail_distr), 50);

        $distribut = Distribut::findOrFail($id);
        $distribut->update($validateData);

        if ($distribut) {
            return redirect()->route('distribut.index')->with('success', 'Distributor successfully updated');
        } else {
            return redirect()->route('distribut.index')->with('errors', 'Distributor failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(distribut $distribut)
    {
        if ($distribut->image) {
            Storage::delete($distribut->image);
        }
        
        try {
            Distribut::destroy($distribut->id);
            return redirect()->route('distribut.index')->with('errors', 'Distributor successfully deleted');
        } catch (Throwable $err) {
            return redirect()->route('distribut.index')->with('errors', "Distributor failed to delete".$err);
        }
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Distribut::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
