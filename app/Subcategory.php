<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
  protected $fillable = [
    'name', 'weight', 'category_id', 'type',
  ];

  public function category() {
    return $this->belongsTo(Category::class);
  }
}
