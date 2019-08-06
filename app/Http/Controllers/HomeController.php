<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        NavigationController::set('Home');
        return view('home');
    }
}
