<?php

namespace App\Exports\ISO;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Help\Help;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

class ISOR1_Export implements FromView, ShouldAutoSize
{
    public $data;
    public function __construct($data)
    {
        $this->data= $data;
    }



    public function view(): View
    {

        $h = new Help();
        return view('pdf-reports.iso.r1-excel',[
                'contenedores' => $this->data,
        ]);
    }

}
