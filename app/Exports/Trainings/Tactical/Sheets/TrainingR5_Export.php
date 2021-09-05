<?php

namespace App\Exports\Trainings\Tactical\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class TrainingR5_Export implements FromView, WithColumnWidths, WithDrawings, WithTitle
{
    protected $query;
    
    public function __construct($query,$text,$tipo,$aprobados,$reprobados,$sin_nota)
    {
        $this->query = $query;
        $this->text = $text;        
        $this->tipo = $tipo;
        $this->aprobados = $aprobados;
        $this->reprobados = $reprobados;
        $this->sin_nota = $sin_nota;
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
        return view('pdf-reports.capacitaciones.r5-tactico-excel', [
            'query' => $this->query,
            'text' => $this->text,            
            'tipo' => $this->tipo,
            'aprobados' => $this->aprobados,
            'reprobados' => $this->reprobados,
            'sin_nota' => $this->sin_nota,
        ]);   
    }    

    public function columnWidths(): array
    {
        return [
            'A' => 14,
            'B' => 14,
            'C' => 45,
            'D' => 13,            
            'E' => 45,
            'F' => 45,
            'G' => 45,
            'H' => 45,
        ];
    } 

    public function title(): string
    {
        return $this->query->training;
    }
}

