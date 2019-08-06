<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        NavigationController::set('Dashboard', [
            'link' => false,
            'icon' => 'far fa-chart-network',
            'value' => ucfirst('Dashboard'),
        ]);
        return view('dashboard');
    }
}
