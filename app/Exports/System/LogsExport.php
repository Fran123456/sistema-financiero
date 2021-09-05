<?php

namespace App\Exports\System;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithTitle;

class LogsExport implements FromView, WithColumnWidths, WithDrawings, WithTitle
{
    protected $query;
    
    public function __construct($query,$fi,$ff)
    {
        $this->query = $query;
        $this->fi = $fi;
        $this->ff = $ff;
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('images\logos\catalana.jpg'));
        $drawing->setHeight(80);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function view(): View
    {
        return view('pdf-reports.system.logs-excel', [
            'query' => $this->query,
            'start_date' => $this->fi,
            'end_date' => $this->ff,
        ]);   
    }    

    public function columnWidths(): array
    {
        return [
            'A' => 14,
            'B' => 14,
            'C' => 45,
            'D' => 45,
            'E' => 45,
            'F' => 45,                        
        ];
    }    

    public function title(): string
    {
        return 'Bitácora';
    }
}
