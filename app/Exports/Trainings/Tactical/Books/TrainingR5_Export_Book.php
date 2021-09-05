<?php

namespace App\Exports\Trainings\Tactical\Books;

use App\Exports\Trainings\Tactical\Sheets\TrainingR5_Export;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TrainingR5_Export_Book implements WithMultipleSheets
{
    use Exportable;
        
    public function __construct($query,$text,$tipo,$aprobados,$reprobados,$sin_nota)
    {
        $this->query = $query;
        $this->text = $text;        
        $this->tipo = $tipo;
        $this->aprobados = $aprobados;
        $this->reprobados = $reprobados;
        $this->sin_nota = $sin_nota;
    }
   
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->query as $key => $table) {
            $sheets[] = new TrainingR5_Export($table,$this->text,$this->tipo,$this->aprobados[$key],$this->reprobados[$key],$this->sin_nota[$key]);
        }

        return $sheets;
    }
}