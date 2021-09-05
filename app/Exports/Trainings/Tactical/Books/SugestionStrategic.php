<?php

namespace App\Exports\Trainings\Tactical\Books;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Help\Help;

class SugestionStrategic implements FromView, ShouldAutoSize
{
   public $data;
    public function __construct($data, $yi, $yf, $tipo, $typeId)
    {
        $this->data= $data;
        $this->yi= $yi;
        $this->yf= $yf;
        $this->tipo= $tipo;
        $this->typeId= $typeId;
    }

    public function view(): View
    {
        $h = new Help();
        return view('pdf-reports.sugerencias.estrategico-excel',[
                'data' => $this->data,
                'yi' => $this->yi,
                'yf' => $this->yf,
                'tipo' => $this->tipo,
                'typeId' => $this->typeId,
        ]);
    }

}
