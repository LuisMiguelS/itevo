<?php

namespace App\Http\Controllers;

use App\Institute;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutes = Institute::unless(auth()->user()->isAdmin(), function ($query) {
            $query->whereHas('users', function ($q) {
                $q->where('user_id', auth()->id());
            });
        })
            ->orderBy('id','DESC')
            ->paginate();

        return view('home', compact('institutes'));
    }
}
