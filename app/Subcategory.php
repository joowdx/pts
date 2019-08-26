<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model {

  private $standings = [];

  protected $fillable = [
    'name', 'weight', 'category_id', 'type', 'finalized',
  ];

  public function category() {
    return $this->belongsTo(Category::class);
  }

  public function criteria() {
    return $this->hasMany(Criterion::class);
  }

  public function scores() {
    return $this->hasMany(Score::class);
  }

  public function setstandings($contestant_id = null) {
    $contestants = [];
    $judgecount = $this->category->judges->count();
    foreach (($this->category == 'final') ? $this->category->finalists() : $this->category->contestants as $contestant) {
      $contestants[$contestant->id] = $contestant;
      foreach($this->category->judges as $judge) {
        $contestant->average += $judge->score($this->id, $contestant->id);
      }
      $contestant->average = $contestant->average / $judgecount;
      if($contestant_id == $contestant->id) {
        return $contestant;
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
    $this->standings = $contestants;
    return $contestants;
  }

  public function getstandings($contestant_id = null, $final = null) {
    if(!$this->standings) {
      $this->setstandings();
    }
    if($contestant_id) {
      foreach($this->standings as $contestant) {
        if($contestant_id == $contestant->id) {
          return $contestant;
        }
      }
      return;
    } else {
      return $this->standings;
    }
  }

  public function getremark($contestant_id) {
    return @\App\Score::where([
      'contestant_id' => $contestant_id,
      'subcategory_id' => $this->id,
      'type' => 'sub',
    ])->first()->score;
  }

  public function getrank($contestant_id) {
    return @\App\Score::where([
      'contestant_id' => $contestant_id,
      'subcategory_id' => $this->id,
      'type' => 'sub',
    ])->first()->rank;
  }

}
