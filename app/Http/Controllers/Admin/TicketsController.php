<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = (new Ticket())->newQuery()
            ->with(['status:id,name_en', 'category:id,name_en', 'priority:id,name_en', 'project:id,name']);

        if (request()->query()) {
            $tickets->filter(request()->query());
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $tickets->orderBy($attribute, $sort_order);
        } else {
            $tickets->latest();
        }

        $tickets = $tickets->paginate(10)->appends(request()->query());

        return Inertia::render('Admin/Tickets/Index', [
            'tickets' => $tickets,
            'filters' => request()->query(),
            'statuses' => Status::get(['id', 'name_en']),
            'priorities' => Priority::get(['id', 'name_en']),
            'categories' => TicketCategory::get(['id', 'name_en']),
            'projects' => Project::get(['id', 'name']),
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
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
