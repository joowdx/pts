<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
      return Category::all();
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
      return abort(404);
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
        'event_id' => 'required|string|min:1',
        'name' => 'required|string|min:3',
        'eliminate' => 'nullable|string|numeric|not_in:0,1',
        ]);
      $category = Category::create($request->all());
      if($request->has('eliminate') && $request->input('eliminate') > 1) {
        if(\App\Subcategory::where(['category_id' => $category->id, 'type' => 'final'])->get()->first()) {
          return redirect()->back();
        }
        \App\Subcategory::create(['category_id' => $category->id, 'name' => 'Final', 'type' => 'final']);
      } else {
        \App\Subcategory::where(['category_id' => $category->id, 'type' => 'final'])->get()->first()->delete();
      }
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
        Category::find($id)->delete();
        return redirect()->back();
      }
      $request->validate([
        'event_id' => 'required|string|numeric|min:1',
        'name' => 'required|string|min:3',
        'eliminate' => 'nullable|string|numeric|not_in:0,1',
      ]);
      $category = Category::find($id);
      $category->update($request->all());
      if($request->has('eliminate') && $request->input('eliminate') > 1) {
        if(\App\Subcategory::where(['category_id' => $category->id, 'type' => 'final'])->get()->first()) {
          return redirect()->back();
        }
        \App\Subcategory::create(['category_id' => $category->id, 'name' => 'Final', 'type' => 'final']);
      } else {
        \App\Subcategory::where(['category_id' => $category->id, 'type' => 'final'])->get()->first()->delete();
      }
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
      return abort(404);
    }
}
