<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
  protected $fillable = [
    'name', 'weight', 'category_id', 'type',
  ];

  public function category() {
    return $this->belongsTo(Category::class);
  }
}
