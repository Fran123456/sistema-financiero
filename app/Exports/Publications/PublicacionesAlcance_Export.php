<?php

namespace App\Exports\Publications;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PublicacionesAlcance_Export implements FromView, WithTitle, WithEvents, ShouldAutoSize
{
    protected $titulo;

    public function __construct($publicaciones, $titulo, $year)
    {
        $this->publicaciones = $publicaciones;
        $this->titulo = $titulo;
        $this->year = $year;
    }

    public function view(): View
    {
        return view('pdf-reports.publicaciones.publicaciones-alcance-estrategico-excel', [
            'publicaciones' => $this->publicaciones,
            'year' => $this->year,
        ]);
    }

    public function title(): string
    {
        return $this->titulo;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $style_text_center = [
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ]
                ];
                $event->sheet->getStyle('E3:E4')->applyFromArray($style_text_center);
                $event->sheet->getStyle('D1')->applyFromArray($style_text_center);
                $event->sheet->getStyle('D1')->applyFromArray($style_text_center);
            },
        ];
    }
}
