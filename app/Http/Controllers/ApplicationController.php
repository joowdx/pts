<?php

namespace App\Http\Controllers;

use App\Application;

class ApplicationController extends Controller {

  public static function index() {
    return Application::all();
  }

  public static function get($key) {
    $value = Application::where('key', $key)->first();
    return $value ? $value->value : '';
  }

}
