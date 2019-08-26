<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model {

  protected $fillable = [
    'judge_id', 'contestant_id', 'category_id', 'subcategory_id', 'criterion_id', 'score', 'type',
  ];

  public function judge() {
    return $this->belongsTo(Judge::class);
  }

  public function contestant() {
    return $this->belongsTo(Contestant::class);
  }

  public function category() {
    return $this->belongsTo(Category::class);
  }
  public function subcategory() {
    return $this->belongsTo(Subcategory::class);
  }

  public function criterion() {
    return $this->belongsTo(Criterion::class);
  }

}
