<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
      'name', 'scoring', 'active',
    ];

    public function categories() {
      return $this->hasMany(Category::class);
    }
}
