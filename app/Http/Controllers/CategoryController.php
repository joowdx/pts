<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller {
    public function index() {
      return Category::all();
    }

    public function create() {
      return abort(404);
    }

    public function store(Request $request) {
      $request->validate([
        'event_id' => 'required|string|min:1',
        'name' => 'required|string|min:3',
        'eliminate' => 'nullable|string|numeric|min:2',
        'scoring' => 'nullable|string|in:avg,rnk,pts',
        'score_by' => 'nullable|string|in:cat,crit,cont',
      ]);
      $category = Category::create($request->all());
      if($request->has('eliminate') && $request->input('eliminate') > 1) {
        if(\App\Subcategory::where(['category_id' => $category->id, 'type' => 'final'])->get()->first()) {
          return redirect()->back();
        }
        \App\Subcategory::create(['category_id' => $category->id, 'name' => 'Final', 'type' => 'final']);
      } else {
        $delete = \App\Subcategory::where(['category_id' => $category->id, 'type' => 'final'])->get()->first();
        $delete ? $delete->delete() : null;
      }
      return redirect()->back();
    }

    public function show($id) {
      return abort(404);
    }

    public function edit($id) {
      return abort(404);
    }

    public function update(Request $request, $id) {
      $request->validate([
        'event_id' => 'required|string|numeric|min:1',
        'name' => 'required|string|min:3',
        'eliminate' => 'nullable|string|numeric|not_in:0,1',
        'scoring' => 'nullable|string|in:avg,rnk,pts',
        'score_by' => 'nullable|string|in:cat,crit,cont',
      ]);
      $category = \App\Category::find($id);
      foreach($category->contestants as $contestant) {
        if(@in_array(@$contestant->id, @$request->input('contestants'))) {
          $contestant->update(['finalist' => true]);
        } else {
          $contestant->update(['finalist' => false]);
        }
      }
      $category = Category::find($id);
      $category->update($request->all());
      if($request->has('eliminate') && $request->input('eliminate') > 1) {
        if(\App\Subcategory::where(['category_id' => $category->id, 'type' => 'final'])->get()->first()) {
          return redirect()->back();
        }
        \App\Subcategory::create(['category_id' => $category->id, 'name' => 'Final', 'type' => 'final']);
      } else {
        $delete = \App\Subcategory::where(['category_id' => $category->id, 'type' => 'final'])->get()->first();
        $delete ? $delete->delete() : null;
      }
      return redirect()->back();
    }

    public function destroy($id) {
      Category::find($id)->delete();
      return redirect()->back();
    }
}
