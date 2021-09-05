<?php

namespace App\Exports\Suggestions\Tactical\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class SuggestionsR2_Export implements FromView, WithColumnWidths, WithDrawings,WithTitle
{
    protected $query;
    
    public function __construct($query,$text,$fi,$ff,$tipo)
    {
        $this->query = $query;
        $this->text = $text;
        $this->fi = $fi;
        $this->ff = $ff;
        $this->tipo = $tipo;
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
        return view('pdf-reports.sugerencias.tactico-excel', [
            'query' => $this->query,
            'text' => $this->text,
            'fi' => $this->fi,
            'ff' => $this->ff,
            'tipo' => $this->tipo
        ]);   
    }    

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 60,
            'C' => 40,
            'D' => 15,
            'E' => 15,
            'F' => 20
        ];
    }
    
    public function title(): string
    {
        return $this->text;
    }
}
