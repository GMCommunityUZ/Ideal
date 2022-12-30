<?php

namespace App\Imports;

use App\Models\Graphic;
use Maatwebsite\Excel\Concerns\ToModel;

class GraphicImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Graphic([
            //
        ]);
    }
}
