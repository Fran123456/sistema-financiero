<?php

namespace App\Exports\Trainings\Tactical\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class TrainingR6_Export implements FromView, WithColumnWidths, WithDrawings, WithTitle
{
    protected $query;
    
    public function __construct($query,$text,$tipo,$empleados)
    {
        $this->query = $query;
        $this->text = $text;        
        $this->tipo = $tipo;
        $this->empleados = $empleados;
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
        return view('pdf-reports.capacitaciones.r6-tactico-excel', [
            'query' => $this->query,
            'text' => $this->text,            
            'tipo' => $this->tipo,
            'empleados' => $this->empleados,
        ]);   
    }    

    public function columnWidths(): array
    {
        return [
            'A' => 14,
            'B' => 14,
            'C' => 40,
            'D' => 40,            
            'E' => 40,
            'F' => 40,
            'G' => 40,            
        ];
    }    

    public function title(): string
    {
        return $this->query->training;
    }
}
