<?php

namespace App\Http\Controllers\Admin;

use App\Charts\MonthlyCompanyTicketsChart;
use App\Charts\MonthlyTicketsChart;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportsController extends Controller
{
    public function ticketsChart(MonthlyTicketsChart $chart)
    {
        return Inertia::render('Admin/Reports/TicketsChart', ['chart' => $chart->build()]);
    }

    public function companyChart(MonthlyCompanyTicketsChart $chart, Request $request)
    {
        $companies = Company::get(['id', 'name']);

        return Inertia::render('Admin/Reports/CompanyChart', [
            'chart' => $chart->build($request->input('company_id', 1)),
            'companies' => $companies,
            'filters' => request()->query(),
        ]);
    }
}
