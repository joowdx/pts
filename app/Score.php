<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model {

  protected $fillable = [
    'judge_id', 'contestant_id', 'subcategory_id', 'score',
  ];

  public function judge() {
    return $this->belongsTo(Judge::class);
  }

  public function contestant() {
    return $this->belongsTo(Contestant::class);
  }

  public function subcategory() {
    return $this->belongsTo(Subcategory::class);
  }

  public function standings () {

  }

}
