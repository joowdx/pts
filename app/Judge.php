<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Score;

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

  public function standings() {

  }

}
