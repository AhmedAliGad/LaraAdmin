<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = (new Company())->newQuery()->withCount('projects');

        if (request()->has('search')) {
            $companies->where('name', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $companies->orderBy($attribute, $sort_order);
        } else {
            $companies->latest();
        }

        $companies = $companies->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/Companies/Index', [
            'companies' => $companies,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Companies/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $company = Company::create($request->input());

        if ($request->hasFile('image')) {
            $company->storeImage($request->file('image')->store('companies', 'public'));
        }

        return redirect()->route('companies.index')->with('message', 'Added Successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $projects = $company->projects()->withCount('tickets')->get();

        return Inertia::render('Admin/Companies/Projects', [
            'company' => $company, 'projects' => $projects]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return Inertia::render('Admin/Companies/Edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $company->update($request->input());

        if ($request->hasFile('image')) {
            $company->updateImage($request->file('image')->store('companies', 'public'));
        }

        return redirect()->route('companies.index')->with('message', 'Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if (count($company->projects)) {
            return redirect()->back()->with('alert', 'Sorry Can\'t delete this item !');
        } else {
            $company->delete();

            return redirect()->back()->with('message', 'Deleted Successfully !');
        }
    }
}
