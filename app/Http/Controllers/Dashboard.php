<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index(Request $request)
    {
        return view('controllers.dashboard.index', [
            'request' => $request
        ]);
    }
}
