<?php

namespace App\Exports;

use App\Models\VoiceRecord;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportVoice implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return VoiceRecord::all();
    }
}
