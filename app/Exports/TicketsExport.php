<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return [
            'Title',
            'Project',
            'Category',
            'Status',
            'Priority',
            'Platform',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->title,
            $ticket->project ? $ticket->project->name : '',
            $ticket->category ? $ticket->category->name_en : '',
            $ticket->status ? $ticket->status->name_en : '',
            $ticket->priority ? $ticket->priority->name_en : '',
            $ticket->device_os
        ];
    }
}
