<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = [
    'event_id', 'name', 'eliminate',
  ];

  public function judges() {
    return $this->belongsToMany(Judge::class)->withTimestamps();
  }

  public function criteria() {
    return $this->hasMany(Criterion::class);
  }
}
