<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public static function index() {
        NavigationController::set('Settings', [
            'link' => false,
            'icon' => 'fas fa-cogs',
            'value' => 'Settings',
        ]);
        return view('settings');
    }
}
