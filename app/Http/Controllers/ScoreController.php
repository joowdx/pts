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
    if($request->input('by') == 'contestant') {
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
    else if($request->input('by') == 'criteria') {
      $request->validate([
        'judge_id' => 'required|string|numeric|exists:judges,id',
        'subcategory_id' => 'required|string|numeric|exists:subcategories,id',
      ]);
      $subcategory = \App\Subcategory::find($request->input('subcategory_id'));
      $totalweight = $subcategory->criteria()->pluck('weight')->sum();
      for($i = 0; $i < count($request->input('contestant_id')); $i++) {
        $score = 0;
        foreach($subcategory->criteria as $criterion ) {
          if($request->input($criterion->id)[$i] > 100 || $request->input($criterion->id)[$i] < 0 || !ctype_digit($request->input($criterion->id)[$i])) {
            continue;
          }
          Score::firstOrCreate([
            'judge_id' => $request->input('judge_id'),
            'criterion_id' => $criterion->id,
            'contestant_id' => $request->input('contestant_id')[$i],
          ])->update([
            'score' => trim($request->input($criterion->id)[$i]),
          ]);
          $score += $request->input($criterion->id)[$i] * $criterion->weight / $totalweight;
        }
        Score::firstOrCreate([
          'judge_id' => $request->input('judge_id'),
          'subcategory_id' => $subcategory->id,
          'contestant_id' => $request->input('contestant_id')[$i],
        ])->update([
          'score' => $score,
          'type' => 'jud',
        ]);
        $scoring_judges_count = 0;
        $scoring_judges_total = 0;
        foreach($subcategory->category->judges as $judge) {
          $scoring_judges_count += $judge->scored($subcategory->id) ? 1 : 0;
          $scoring_judges_total += @Score::where([
            'judge_id' => $judge->id,
            'subcategory_id' => $subcategory->id,
            'contestant_id' => $request->input('contestant_id')[$i],
            'type' => 'jud',
          ])->first()->score;
        }
        $sub = Score::firstOrCreate([
          'contestant_id' => $request->input('contestant_id')[$i],
          'subcategory_id' => $subcategory->id,
          'type' => 'sub',
        ]);
        $sub->update([
          'score' => $scoring_judges_total / $scoring_judges_count,
        ]);
      }
      Judge::find($request->input('judge_id'))->setstandings($subcategory->category->id);
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
    $subcategory = Subcategory::find($request->input('subcategory_id'));
    if($subcategory->category->judges->contains($request->input('judge_id'))) {
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
    Judge::find($request->input('judge_id'))->setstandings($subcategory->category->id);
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
