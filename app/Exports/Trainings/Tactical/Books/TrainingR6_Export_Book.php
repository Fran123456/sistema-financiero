<?php

namespace App\Exports\Trainings\Tactical\Books;

use App\Exports\Trainings\Tactical\Sheets\TrainingR6_Export;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TrainingR6_Export_Book implements WithMultipleSheets
{
    use Exportable;
        
    public function __construct($query,$text,$tipo,$empleados)
    {
        $this->query = $query;
        $this->text = $text;
        $this->tipo = $tipo;
        $this->empleados = $empleados;
    }
    
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->query as $key => $table) {
            $sheets[] = new TrainingR6_Export($table,$this->text,$this->tipo,$this->empleados[$key]);
        }

        return $sheets;
    }
}