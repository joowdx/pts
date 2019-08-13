<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
      'name', 'active',
    ];

    public function categories() {
      return $this->hasMany(Category::class);
    }

    public function contestants() {
      return $this->hasManyThrough(Contestant::class, Category::class);
    }
}
