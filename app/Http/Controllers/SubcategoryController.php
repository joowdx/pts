<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      $request->validate([
        'category_id' => 'required|string|numeric|min:1',
        'name' => 'required|string|min:3',
        'weight' => 'required|string|numeric',
        'type' => 'nullable|string|in:final',
      ]);
      Subcategory::create($request->all());
      return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
      if($request->has('delete')) {
        Subcategory::find($id)->delete();
        return redirect()->back();
      }
      $request->validate([
        'category_id' => 'required|string|numeric|min:1',
        'name' => 'required|string|min:3',
        'type' => 'nullable|string|in:final',
      ]);
      if(Subcategory::find($id)->type != 'final') {
        $request->validate(['weight' => 'required|string|numeric']);
      }
      Subcategory::find($id)->update($request->all());
      return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
