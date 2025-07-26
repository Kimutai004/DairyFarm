<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Redirect admin users to admin dashboard
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Show farmer dashboard for regular users
        return view('home');
    }
}
