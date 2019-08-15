<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Score;
use App\Category;
use App\Subcategory;

class Judge extends Model {
  protected $fillable = [
    'name', 'number', 'pin', 'token',
  ];

  public function categories() {
    return $this->belongsToMany(Category::class)->withTimestamps();
  }

  public function scores() {
    return $this->hasMany(Score::class);
  }

  public function score($subcategory_id, $contestant_id) {
    return @Score::where([
      'judge_id' => $this->id,
      'subcategory_id' => $subcategory_id,
      'contestant_id' => $contestant_id
    ])->get()->first()->score;
  }

  public function standings($category_id) {
    $category = Category::find($category_id);
    $standings = [];
    foreach($category->contestants as $contestant) {
      $standings[$contestant->number] = [
        'contestant' => $contestant,
        'total' => 0,
      ];
      if($category->scoring == 'rnk'){
        $standings[$contestant->number] = [
          'contestant' => $contestant,
          'total' => 0,
          'rank' => 0,
        ];
      } else if($category->scoring == 'avg') {
        $standings[$contestant->number] = [
          'contestant' => $contestant,
          'total' => 0,
          'average' => 0,
        ];
      }
      $totalweight = 0;
      if($category->scoring == 'avg') {
        $totalweight = Subcategory::where(['category_id' => $category->id])->get()->pluck('weight')->sum();
      }
      foreach($category->subcategories as $subcategory) {
        $standings[$contestant->number]['total'] += $this->score($subcategory->id, $contestant->id);
        if($category->scoring == 'avg') {
        $standings[$contestant->number]['average'] += $this->score($subcategory->id, $contestant->id) * $subcategory->weight / ($totalweight ? $totalweight : 1);
        }
      }
    }
    usort($standings,function($a,$b){return($a['total']==$b['total']?0:$a['total']>$b['total'])?-1:1;});
    if($category->scoring == 'rnk') {
      $tmp = null;
      $rank = 1;
      foreach ($standings as $k => $v) {
        $contestant = $standings[$k]['contestant'];
        $contestant->total = $v['total'];
        $contestant->remark = $v['total'] == @$tmp['total'] ? $contestant->remark = @$tmp->remark : $rank;
        $standings[$k] = $contestant;
        $tmp = $standings[$k];
        $rank++;
      }
      return $standings;
    } else if($category->scoring == 'avg') {
      $tmp = null;
      $rank = 1;
      foreach ($standings as $k => $v) {
        $contestant = $standings[$k]['contestant'];
        $contestant->total = $v['total'];
        $contestant->remark = number_format((float)$v['average'], 2, '.', '');
        $standings[$k] = $contestant;
        $tmp = $standings[$k];
      }
      return $standings;
    } else {
      $tmp = null;
      $rank = 1;
      foreach ($standings as $k => $v) {
        $contestant = $standings[$k]['contestant'];
        $contestant->total = $v['total'];
        $contestant->remark = $v['total'];
        $standings[$k] = $contestant;
        $tmp = $standings[$k];
      }
      return $standings;
    }
  }

}
