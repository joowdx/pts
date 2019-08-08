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

  public function contestants() {
    return $this->hasMany(Contestant::class);
  }

  public function subcategories() {
    return $this->hasMany(Subcategory::class);
  }
}
