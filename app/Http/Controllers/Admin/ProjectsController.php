<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Project;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $projects = (new Project())->newQuery()->with(['company:id,name'])->withCount('tickets');
        } else {
            if (auth()->user()->company) {
                $projects = (new Project())->newQuery()->where('company_id', auth()->user()->company_id)
                    ->with(['company:id,name'])->withCount('tickets');
            } else {
                $projects = (new Project())->newQuery()->whereIn('id', auth()->user()->projects ?: [])
                    ->with(['company:id,name'])->withCount('tickets');
            }
        }

        if (request()->has('search')) {
            $projects->where('name', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $projects->orderBy($attribute, $sort_order);
        } else {
            $projects->latest();
        }

        $projects = $projects->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/Projects/Index', [
            'projects' => $projects,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Projects/Create', [
            'companies' => Company::get(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $project = Project::create($request->input());

        return redirect()->route('projects.index')->with('message', 'Added Successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Request $request)
    {
        $statuses = Status::get(['id', 'name_en']);
        $query = $project->tickets()->get(['id', 'status_id']);
        if ($request->filled('status')) {
            $tickets = $project->tickets()->where('status_id', $request->get('status'))
                ->with(['status', 'priority', 'category'])->get();
        } else {
            $tickets = $project->tickets()->with(['status', 'priority', 'category'])->get();
        }
        $counters = [];
        foreach ($statuses as $status) {
            array_push($counters, [
                'id' => $status->id, 'counter_name' => $status->name_en,
                'counter_value' => $query->where('status_id', $status->id)->count()
            ]);
        }

        return Inertia::render('Admin/Projects/Tickets', [
            'project' => $project->loadCount('tickets'),
            'statuses' => collect($counters),
            'tickets' => $tickets
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return Inertia::render('Admin/Projects/Edit', [
            'project' => $project,
            'companies' => Company::get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $project->update($request->input());

        return redirect()->route('projects.index')->with('message', 'Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (count($project->tickets)) {
            return redirect()->back()->with('alert', 'Sorry Can\'t delete this item !');
        } else {
            $project->delete();

            return redirect()->back()->with('message', 'Deleted Successfully !');
        }
    }
}
