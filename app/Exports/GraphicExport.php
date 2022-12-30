<?php

namespace App\Exports;

use App\Models\Graphic;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
//use Maatwebsite\Excel\Concerns\WithHeadings;

class GraphicExport implements FromView
{

    public function __construct($graphics)
    {
        $this->graphics = $graphics;
    }
    public function view(): View
    {
       return view('pages.graphic.export', ['graphics'=>$this->graphics]);
    }
//
//    public function headings(): array
//    {
//        return [
//            'Ism',
//            'Sana',
//            'To\'lov',
//            'Qarz',
//            'Chegirma',
//        ];
//    }

}
