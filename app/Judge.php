<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Score;
use App\Contestant;
use App\Category;
use App\Subcategory;
use Error;

class Judge extends Model {

  private $standings = [];

  protected $fillable = [
    'name', 'number', 'pin', 'token',
  ];

  public function categories() {
    return $this->belongsToMany(Category::class)->withTimestamps();
  }

  public function scores() {
    return $this->hasMany(Score::class);
  }

  public function score($id, $contestant, $crit = null) {
    if($crit) {
      return @Score::where([
        'judge_id' => $this->id,
        'criterion_id' => $id,
        'contestant_id' => $contestant
      ])->get()->first()->score;
    }
    return @Score::where([
      'judge_id' => $this->id,
      'subcategory_id' => $id,
      'contestant_id' => $contestant
    ])->get()->first()->score;
  }

  public function final($category_id, $contestant_id = null) {
    $category = Category::find($category_id);
    $contestants = [];
    foreach ($category->finalists() as $contestant) {
      $contestants[$contestant->number] = $contestant;
      $final = Subcategory::where(['category_id' => $category->id, 'type' => 'final'])->get()->first();
      $contestant->average = $this->score($final->id, $contestant->id);
      if($contestant_id == $contestant->id) {
        return $contestant;
      }
    }
    return $contestants;
  }

  public function setstandings($category_id, $contestant_id = null) {
    $category = Category::find($category_id);
    $totalweight = Subcategory::where(['category_id' => $category->id])->get()->pluck('weight')->sum();
    $contestants = [];
    foreach($category->contestants as $contestant) {
      $contestants[$contestant->number] = $contestant;
      foreach($category->subcategories as $subcategory) {
        if(!$this->scored($subcategory->id) || $subcategory->type == 'final') {
          continue;
        }
        $contestant->average += $this->score($subcategory->id, $contestant->id) * $subcategory->weight / ($totalweight ? $totalweight : 1);
      }
    }
    usort($contestants,function($a,$b){return($a->average==$b->average?0:$a->average>$b->average)?-1:1;});
    $tmp = null;
    $rank = 1;
    foreach ($contestants as $contestant) {
      $contestant->rank = $contestant->average == @$tmp->average ? @$tmp->rank : $rank;
      $tmp = $contestant;
      $rank++;
      if($contestant_id == $contestant->id) {
        return $contestant;
      }
    }
    $this->standings[$category_id] = $contestants;
    return $contestants;
  }

  public function getstandings($category_id, $contestant_id = null) {
    if(!$this->standings || !$this->standings[$category_id]) {
      $this->setstandings($category_id);
    }
    if($contestant_id) {
      foreach ($this->standings[$category_id] as $contestant) {
        if($contestant_id == $contestant->id) {
          return $contestant;
        }
      }
    } else {
      return $this->standings[$category_id];
    }
  }

  public function scored($subcategory_id) {
    return Score::where([
      'judge_id' => $this->id,
      'subcategory_id' => $subcategory_id,
    ])->first() ? 1 : 0;
  }

  public function getrank($subcategory_id, $contestant_id) {
    return @\App\Score::where([
      'contestant_id' => $contestant_id,
      'subcategory_id' => $this->id,
      'type' => 'sub',
    ])->first()->rank;
  }
}
