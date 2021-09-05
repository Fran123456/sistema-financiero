<?php

namespace App\Exports\Trainings\Tactical\Books;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Help\Help;

class TrainingR1_Export_Book implements FromView, ShouldAutoSize
{
   public $data;
    public function __construct($data)
    {
        $this->data= $data;
    }

    public function view(): View
    {
        $h = new Help();
        return view('pdf-reports.capacitaciones.r1-estrategico-excel',[
                'scores' => $this->data,
        ]);
    }

}
