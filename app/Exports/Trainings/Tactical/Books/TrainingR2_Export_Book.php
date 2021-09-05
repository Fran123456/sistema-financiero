<?php

namespace App\Exports\Trainings\Tactical\Books;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Help\Help;

class TrainingR2_Export_Book implements FromView, ShouldAutoSize
{
   public $data;
    public function __construct($data, $yeari, $yearf)
    {
        $this->data= $data;
        $this->yeari= $yeari;
        $this->yearf= $yearf;
    }

    public function view(): View
    {
        $h = new Help();
        return view('pdf-reports.capacitaciones.r2-estrategico-excel',[
                'data' => $this->data,
                'yeari' => $this->yeari,
                'yearf' => $this->yearf,
        ]);
    }

}
