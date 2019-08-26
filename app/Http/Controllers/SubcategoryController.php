<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;

class SubcategoryController extends Controller {
  public function index() {
  }

  public function create() {

  }

  public function store(Request $request) {
    $request->validate([
      'category_id' => 'required|string|numeric|min:1',
      'name' => 'required|string|min:3',
      'weight' => 'nullable|string|numeric',
      'type' => 'nullable|string|in:final',
    ]);
    Subcategory::create($request->all());
    return redirect()->back();
  }

  public function show($id) {

  }

  public function edit($id) {

  }

  public function update(Request $request, $id) {
    $subcategory = Subcategory::find($id);
    if($request->has('criteria')) {
      for ($i=0; $i < count($request->input('criterion_name')); $i++) {
        if(@$request->input('criterion_id')[$i]) {
          if($request->input('criterion_name')[$i] && $request->input('criterion_weight')) {
            if(!ctype_digit($request->input('criterion_weight')[$i])) {
              continue;
            }
            @\App\Criterion::find($request->input('criterion_id')[$i])->update([
              'name' => $request->input('criterion_name')[$i],
              'weight' => $request->input('criterion_weight')[$i]
            ]);
          }
          else {
            @\App\Criterion::find($request->input('criterion_id')[$i])->delete();
          }
        } else {
          if($request->input('criterion_name')[$i] && $request->input('criterion_weight') && ctype_digit($request->input('criterion_weight')[$i])) {
            \App\Criterion::create(['subcategory_id' => $id])->update([
              'name' => $request->input('criterion_name')[$i],
              'weight' => $request->input('criterion_weight')[$i],
            ]);
          }
        }
      }
    } else if($request->has('clear')) {
      foreach($subcategory->criteria as $criterion) {
        $criterion->delete();
      }
      return redirect()->back();
    }
    if($request->has('delete')) {
      $subcategory->delete();
      return redirect()->back();
    }
    $request->validate([
      'category_id' => 'required|string|numeric|min:1',
      'name' => 'required|string|min:3',
      'type' => 'nullable|string|in:final',
    ]);
    if($subcategory->type != 'final' && $subcategory->category->scoring == 'avg') {
      $request->validate(['weight' => 'required|string|numeric']);
    }
    $subcategory->update($request->all());
    return redirect()->back();
  }

  public function destroy($id) {

  }
}
