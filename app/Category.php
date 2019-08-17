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
    'event_id', 'name', 'eliminate', 'scoring',
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

  public function standings($contestant_id = null) {
    $contestant = Contestant::find($contestant_id);
    foreach($this->judges as $judge) {
      $contestant->total += $judge->standings($this->id, $contestant->id)->remark;
      if($this->scoring == 'avg') {
        $contestant->remark += $judge->standings($this->id, $contestant->id)->remark;
      }
    }
    if($this->scoring == 'avg') {
      $contestant->remark = ($contestant->remark / $this->judges->count());
    }
    return $contestant;
  }
}
