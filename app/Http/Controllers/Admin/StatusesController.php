<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = (new Status())->newQuery();

        if (request()->has('search')) {
            $statuses->where('name_en', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $statuses->orderBy($attribute, $sort_order);
        } else {
            $statuses->latest();
        }

        $statuses = $statuses->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/Statuses/Index', [
            'statuses' => $statuses,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Statuses/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = Status::create($request->input());

        return redirect()->route('statuses.index')->with('message', 'Added Successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        return Inertia::render('Admin/Statuses/Edit', [
            'status' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        $status->update($request->input());

        return redirect()->route('statuses.index')->with('message', 'Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        if (count($status->tickets)) {
            return redirect()->back()->with('alert', 'Sorry Can\'t delete this item !');
        } else {
            $status->delete();

            return redirect()->back()->with('message', 'Deleted Successfully !');
        }
    }
}
