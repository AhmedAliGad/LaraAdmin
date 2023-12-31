<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SupportTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = (new User)->newQuery()->where('role', 'support');

        if (request()->has('search')) {
            $users->where('name', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $users->orderBy($attribute, $sort_order);
        } else {
            $users->latest();
        }

        $users = $users->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/SupportTeams/Index', [
            'users' => $users,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/SupportTeams/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create($request->except('password') + ['password' => bcrypt($request->input('password'))]);

        return redirect()->route('support_teams.index')->with('message', 'Member created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render('Admin/SupportTeams/Edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($request->filled('password') && $user->password != $request->get('password')) {
            $user->update($request->except('password') + [
                    'password' => bcrypt($request->input('password')),
                ]);
        } else {
            $user->update($request->except('password'));
        }

        return redirect()->route('support_teams.index')->with('success', 'Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
