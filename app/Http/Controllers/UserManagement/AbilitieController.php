<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Silber\Bouncer\Database\Ability;
use App\Http\Requests\UserManagement\CreateAbilitieRequest;
use App\Http\Requests\UserManagement\UpdateAbilitieRequest;

class AbilitieController extends Controller
{
    /**
     * Display a listing of Abilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abilities = Ability::paginate();
        return view('user_management.abilities.index', compact('abilities'));
    }

    /**
     * Show the form for creating new Ability.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user_management.abilities.create');
    }

    /**
     * Store a newly created Ability in storage.
     *
     * @param \App\Http\Requests\UserManagement\CreateAbilitieRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAbilitieRequest $request)
    {
        Ability::create($request->all());
        return redirect()->route('abilities.index');
    }

    /**
     * Show the form for editing Ability.
     *
     * @param \Silber\Bouncer\Database\Ability $ability
     * @return \Illuminate\Http\Response
     */
    public function edit(Ability $ability)
    {
        return view('user_management.abilities.edit', compact('ability'));
    }

    /**
     * Update Ability in storage.
     *
     * @param \App\Http\Requests\UserManagement\UpdateAbilitieRequest $request
     * @param \Silber\Bouncer\Database\Ability $ability
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAbilitieRequest $request, Ability $ability)
    {
        $ability->update($request->all());
        return redirect()->route('abilities.index');
    }

    /**
     * Remove Ability from storage.
     *
     * @param \Silber\Bouncer\Database\Ability $ability
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Ability $ability)
    {
        $ability->delete();
        return redirect()->route('user_management.abilities.index');
    }

    /**
     * Delete all selected Ability at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Ability::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
