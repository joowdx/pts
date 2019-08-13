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
        'subcategory' => $category,
        'contestant' => $contestant,
        'total' => 0,
      ];
      foreach($category->subcategories as $subcategory) {
        $standings[$contestant->number]['total'] += $this->score($subcategory->id, $contestant->id);
      }
    }
    if($category->scoring == 'rnk') {
      usort($standings,function($a,$b){return($a['total']==$b['total']?0:$a['total']>$b['total'])?-1:1;});
      $tmp = null;
      $rank = 1;
      foreach ($standings as $k => $v) {
        if($v['total'] == @$tmp['total']) {
          $standings[$k]['rank'] = $tmp['rank'];
          $rank++;
          $tmp = $standings[$k];
          continue;
        }
        $standings[$k]['rank'] = $rank;
        $rank++;
        $tmp = $standings[$k];
      }
      return $standings;
    } else if($category->scoring == 'avg') {
      return $standings;
    }
    return $standings;
  }

}
