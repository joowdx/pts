<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() {
        NavigationController::set('Profile', [
            'link' => false,
            'icon' => 'far fa-users-cog',
            'value' => ucfirst('Profile'),
        ]);
        return view('profile');
    }
}
