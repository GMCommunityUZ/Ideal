<?php

namespace App\Exports;

use App\Models\Graphic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GraphicExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'Ism',
            'Oy',
            'To\'lov',
            'Qarz',
            'Chegirma'];
    }

    public function collection()
    {
        $graphic = Graphic::whereHas('student', function ($query){
            $query->select('name');
        })->select('month', 'paid_amount', 'remaining_amount', 'discount_amount');

        return $graphic->get();
    }

}
