<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CloseReason;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CloseReasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $close_reasons = (new CloseReason())->newQuery();

        if (request()->has('search')) {
            $close_reasons->where('name_en', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $close_reasons->orderBy($attribute, $sort_order);
        } else {
            $close_reasons->latest();
        }

        $close_reasons = $close_reasons->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/CloseReasons/Index', [
            'close_reasons' => $close_reasons,
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
    public function show(CloseReason $closeReason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CloseReason $closeReason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CloseReason $closeReason)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CloseReason $closeReason)
    {
        //
    }
}
