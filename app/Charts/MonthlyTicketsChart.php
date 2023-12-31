<?php

namespace App\Charts;

use App\Models\Ticket;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class MonthlyTicketsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $tickets = Ticket::get(['id', 'created_at'])->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m');
        });
        $ticketsCount = [];
        $chartData = [];
        foreach ($tickets as $key => $value) {
            $ticketsCount[(int) $key] = count($value);
        }
        for ($i = 1; $i <= 12; $i++) {
            if (! empty($ticketsCount[$i])) {
                $chartData[$i] = $ticketsCount[$i];
            } else {
                $chartData[$i] = 0;
            }
        }
        $items = array_values($chartData);
        return $this->chart->barChart()
            ->setTitle('System Tickets during season.')
            ->addData('Number of Tickets', $items)
            ->setXAxis($month)
            ->toVue();
    }
}
