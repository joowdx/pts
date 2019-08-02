<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Judge extends Model {
  protected $fillable = [
    'name', 'number', 'token',
  ];

  public function categories() {
    return $this->belongsToMany(Category::class)->withTimestamps();
  }

}
