<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller {
  public function index() {
    NavigationController::set('About', [
    'link' => false,
    'icon' => 'far fa-info-circle',
    'value' => ucfirst('About'),
    ]);
    return view('about');
  }
}
