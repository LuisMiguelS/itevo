<?php

namespace App\Http\Controllers;

use Silber\Bouncer\Database\Ability;

class AbilitieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of Abilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abilities = Ability::paginate();
        return view('abilities.index', compact('abilities'));
    }
}
