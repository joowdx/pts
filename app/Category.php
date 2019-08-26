<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Score;
use App\Contestant;
use App\Judge;
use App\Subcategory;

class Category extends Model
{
  protected $fillable = [
    'event_id', 'name', 'eliminate', 'scoring', 'score_by',
  ];

  public function judges() {
    return $this->belongsToMany(Judge::class)->withTimestamps();
  }

  public function contestants() {
    return $this->hasMany(Contestant::class);
  }

  public function subcategories() {
    return $this->hasMany(Subcategory::class);
  }

  public function scores() {
    return $this->hasManyThrough(Score::class, Subcategory::class);
  }

  public function finalists() {
    $finalists = $this->contestants->filter(function($c){return $c->finalist;});
    if($finalists->isEmpty()) {
      $finalists = $this->standings();
      return array_splice($finalists, 0, $this->eliminate);
    }
    return $finalists;
  }

  public function standings($contestant_id = null) {
    $contestants = [];
    foreach($this->contestants as $contestant) {
      $contestants[$contestant->number] = $contestant;
      $judge_count = 0;
      foreach($this->judges as $judge) {
        $contestants[$contestant->number]->average += $judge->getstandings($this->id, $contestant->id)->average;
      }
      $contestants[$contestant->number]->average = $contestants[$contestant->number]->average / $this->judges->count();
    }
    usort($contestants,function($a,$b){return($a->average==$b->average?0:$a->average>$b->average)?-1:1;});
    $tmp = null;
    $rank = 1;
    foreach($contestants as $contestant) {
      $contestant->rank = @$tmp->average == $contestant->average ? @$tmp->rank : $rank;
      $rank++;
      $tmp = $contestant;
      if($contestant_id == $contestant->id) {
        return $tmp;
      }
    }
    return $contestants;
  }
}
