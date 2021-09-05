<?php

namespace App\Exports\Trainings\Tactical\Books;

use App\Exports\Trainings\Tactical\Sheets\TrainingR4_Export;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TrainingR4_Export_Book implements WithMultipleSheets
{
    use Exportable;
        
    public function __construct($query,$text,$tipo,$aprobados,$reprobados)
    {
        $this->query = $query;
        $this->text = $text;        
        $this->tipo = $tipo;
        $this->aprobados = $aprobados;
        $this->reprobados = $reprobados;
    }
    
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->query as $key => $table) {
            $sheets[] = new TrainingR4_Export($table,$this->text,$this->tipo,$this->aprobados[$key],$this->reprobados[$key]);
        }

        return $sheets;
    }
}