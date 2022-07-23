<?php

namespace App\Exports;

use App\Models\BaseInfo;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportBaseInfo implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BaseInfo::all();
    }
}
