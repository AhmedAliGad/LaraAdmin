<?php

namespace App\Http\Controllers\Admin;

use App\Charts\MonthlyTicketsChart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportsController extends Controller
{
    public function ticketsChart(MonthlyTicketsChart $chart)
    {
        return Inertia::render('Admin/Settings/Chart', ['chart' => $chart->build()]);
    }
}
