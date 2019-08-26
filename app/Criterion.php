<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criterion extends Model {


  protected $fillable = [
    'subcategory_id', 'name', 'weight',
  ];

  public function subcategory() {
    return $this->belongsTo(Subcategory::class);
  }

}
