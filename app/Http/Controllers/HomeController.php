<?php

namespace App\Http\Controllers;

use App\Models\Notice;

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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notices = Notice::with('cover')->where('is_active', true)->latest()->get();
        return view('welcome', compact('notices'));
    }
}
