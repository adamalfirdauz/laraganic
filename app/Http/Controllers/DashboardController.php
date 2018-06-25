<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $sidebar = 1;
        $head = (object) array();
        $head->title = "Dashboard";
        $head->subtitle = "Summary";
        return view('pages.dashboard', compact('sidebar', 'head'));
    }
}
