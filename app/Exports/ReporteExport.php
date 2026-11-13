<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReporteExport implements FromView, ShouldAutoSize
{
    private $vista;
    private $datos;

    public function __construct($vista, $datos)
    {
        $this->vista = $vista;
        $this->datos = $datos;
    }

    public function view(): View
    {
        return view($this->vista, $this->datos);
    }
}
