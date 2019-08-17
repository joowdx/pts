<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;
use App\Judge;
use App\Contestant;
use App\Score;


class ScoreController extends Controller {

  public function index() {
    return Score::all();
  }

  public function store(Request $request) {
    if($request->has('by') && $request->input('by') == 'contestant') {
      $request->validate([
        'contestant_id' => 'required|string|numeric|exists:contestants,id',
        'judge_id' => 'required|string|numeric|exists:judges,id',
        'subcategory_id.*' => 'string|numeric|exists:subcategories,id',
        'score.*' => 'nullable|string|numeric|min:0|max:100',
        'subcategory_id' => 'required|array',
        'score' => 'required|array',
      ]);
      for($i = 0; $i < count($request->input('score')); $i++) {
        if(Subcategory::find($request->input('subcategory_id')[$i])->category->judges->contains($request->input('judge_id'))) {
          Score::firstOrCreate([
            'judge_id' => $request->input('judge_id'),
            'subcategory_id' => $request->input('subcategory_id')[$i],
            'contestant_id' => $request->input('contestant_id'),
          ])->update([
            'score' => $request->input('score')[$i],
          ]);
        }
      }
      return redirect()->back();
    }
    $request->validate([
      'subcategory_id' => 'required|string|numeric|exists:subcategories,id',
      'judge_id' => 'required|string|numeric|exists:judges,id',
      'contestant_id.*' => 'string|numeric|exists:contestants,id',
      'score.*' => 'nullable|string|numeric|min:0|max:100',
      'contestant_id' => 'required|array',
      'score' => 'required|array',
    ]);
    if(Subcategory::find($request->input('subcategory_id'))->category->judges->contains($request->input('judge_id'))) {
      for($i = 0; $i < count($request->input('score')); $i++) {
        Score::firstOrCreate([
          'judge_id' => $request->input('judge_id'),
          'subcategory_id' => $request->input('subcategory_id'),
          'contestant_id' => $request->input('contestant_id')[$i],
        ])->update([
          'score' => $request->input('score')[$i],
        ]);
      }
      return redirect()->back();
    }
    return abort(404);
  }

  public function update(Request $request, $id) {
    return abort(404);
  }

  public function destroy($id) {

  }

  public function show($id) {

  }

  public function edit($id) {
    return abort(404);
  }

  public function create() {
    return abort(404);
  }
}
