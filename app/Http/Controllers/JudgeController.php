<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Judge;

class JudgeController extends Controller {

  public function index() {
    return Judge::all();
  }

  public function store(Request $request) {
    if($request->has('generate')) {
      if($request->input('generate_count') == null || $request->input('generate_count') == 0) {
        return redirect()->back();
      }
      $count = 0;
      foreach(Judge::all()->sortBy('number') as $judge) {
        $judge->update(['number' => ++$count]);
      }
      for($i = 1; $i <= $request->input('generate_count'); $i++) {
        factory(Judge::class, $request->input('generate'))->create()->update(['number' => $i + $count]);
      }
      return redirect()->back();
    }
    $request->validate([
      'category_id' => 'nullable|array|min:1',
      'name' => 'required|string',
      'number' => 'required|string|numeric',
      'pin' => 'nullable|string|numeric|min:6|max:6',
      'token' => 'nullable|string|min:12|max:12',
    ]);
    $new = Judge::create($request->except('category_id'));
    $new->categories()->sync($request->input('category_id'));
    $count = 0;
    foreach (Judge::all()->sortBy('number') as $judge) {
      $judge->update(['number' => ++$count]);
    }
    return redirect()->back();
  }

  public function update(Request $request, $id) {
    $request->validate([
      'category_id' => 'required|array|min:1',
      'name' => 'required|string',
      'number' => 'required|string|numeric',
      'pin' => 'nullable|string|min:6|max:6',
      'token' => 'nullable|string|min:12|max:12',
    ]);
    $update = Judge::find($id)->update($request->except('category_id'));
    $update->categories()->sync($request->input('category_id'));
    $count = 0;
    foreach (Judge::all()->sortBy('number') as $judge) {
      $judge->update(['number' => ++$count]);
    }
    return redirect()->back();
  }

  public function destroy($id) {
    Judge::find($id)->delete();
    return redirect()->back();
  }

  public function show($id) {
    return abort(404);
  }

  public function edit($id) {
    return abort(404);
  }

  public function create() {
    return abort(404);
  }

}
