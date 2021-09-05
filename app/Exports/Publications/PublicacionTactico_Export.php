<?php

namespace App\Exports\Publications;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PublicacionTactico_Export implements FromView, WithColumnWidths, WithDrawings, WithTitle, WithEvents
{
    protected $titulo;

    public function __construct($publicacion, $titulo)
    {
        $this->publicacion = $publicacion;
        $this->titulo = $titulo;
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('images\logos\catalana.jpg'));
        $drawing->setHeight(80);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function view(): View
    {
        return view('pdf-reports.publicaciones.publicaciones-tactico-excel', [
            'publicacion' => $this->publicacion,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 14,
            'B' => 40,
            'C' => 20,
            'D' => 50,
            'E' => 30,
            'F' => 10,
        ];
    }

    public function title(): string
    {
        return $this->titulo;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $style_text = [
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT
                    ]
                ];
                $event->sheet->getStyle('B8')->applyFromArray($style_text);
            },
        ];
    }
}
