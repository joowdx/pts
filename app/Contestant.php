<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contestant extends Model
{
    protected $fillable = [
      'name', 'number', 'category_id',
    ];

    public function category() {
      return $this->belongsTo(Category::class);
    }
}
