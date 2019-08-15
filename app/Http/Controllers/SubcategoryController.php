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
