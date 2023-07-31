<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrioritiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priorities = (new Priority())->newQuery();

        if (request()->has('search')) {
            $priorities->where('name_en', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $priorities->orderBy($attribute, $sort_order);
        } else {
            $priorities->latest();
        }

        $priorities = $priorities->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/Priorities/Index', [
            'priorities' => $priorities,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Priority $priority)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Priority $priority)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Priority $priority)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Priority $priority)
    {
        //
    }
}
