<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TicketsExport;
use App\Http\Controllers\Controller;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //sleep(2);
        if (auth()->user()->role == 'admin') {
            $tickets = (new Ticket())->newQuery()
                ->with(['status:id,name_en', 'category:id,name_en', 'priority:id,name_en', 'project:id,name']);
        } elseif (auth()->user()->role == 'support') {
            $tickets = (new Ticket())->newQuery()->whereJsonContains('assigned_users', (string) auth()->id())
                ->with(['status:id,name_en', 'category:id,name_en', 'priority:id,name_en', 'project:id,name']);
        } else {
            if (auth()->user()->role == 'supervisor' && auth()->user()->projects) {
                $tickets = (new Ticket())->newQuery()->whereIn('id', auth()->user()->projects)
                    ->with(['status:id,name_en', 'category:id,name_en', 'priority:id,name_en', 'project:id,name']);
            } elseif (auth()->user()->role == 'client' && auth()->user()->company) {
                $tickets = (new Ticket())->newQuery()
                    ->whereHas('project', function ($q) { $q->where('company_id', auth()->user()->company_id);})
                    ->with(['status:id,name_en', 'category:id,name_en', 'priority:id,name_en', 'project:id,name']);
            } else {
                $tickets = (new Ticket())->newQuery()->where('created_by', auth()->id())
                    ->with(['status:id,name_en', 'category:id,name_en', 'priority:id,name_en', 'project:id,name']);
            }
        }

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
        $activities = Activity::where('subject_id', $ticket->id)->with('causer')->get();

        return Inertia::render('Admin/Tickets/Show', [
            'ticket' => $ticket->load(['status:id,name_en', 'category:id,name_en', 'priority:id,name_en',
                'project:id,name', 'createdBy:id,name']),
            'activities' => $activities
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return Inertia::render('Admin/Tickets/Edit', [
            'ticket' => $ticket,
            'statuses' => Status::get(['id', 'name_en']),
            'priorities' => Priority::get(['id', 'name_en']),
            'categories' => TicketCategory::get(['id', 'name_en']),
            'projects' => Project::get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $ticket->update($request->input());

        return redirect()->route('tickets.index')->with('message', 'Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function reports()
    {
        return Inertia::render('Admin/Reports/Tickets', [
            'filters' => request()->query(),
            'statuses' => Status::get(['id', 'name_en']),
            'priorities' => Priority::get(['id', 'name_en']),
            'categories' => TicketCategory::get(['id', 'name_en']),
            'projects' => Project::get(['id', 'name']),
        ]);
    }

    public function export(Request $request)
    {
        $tickets = Ticket::with(['status', 'project:id,name', 'priority', 'category'])
            ->dateFilter($request->date)->projectFilter($request->project_id)->search($request->search)
            ->statusFilter($request->status_id)->categoryFilter($request->category_id)
            ->osFilter($request->device_os)->priorityFilter($request->priority_id)->orderBy('id', 'desc')->get();

        return Excel::download(new TicketsExport($tickets), 'tickets-report.xlsx');
    }
}
