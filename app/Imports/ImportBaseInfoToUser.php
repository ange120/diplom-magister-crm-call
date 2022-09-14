<?php

namespace App\Imports;

use App\Models\BaseInfo;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Status;

class ImportBaseInfoToUser implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BaseInfo([
            'id_client' =>  $row[0],
            'phone'  => $row[1],
            'field_1'  => $row[2],
            'field_2'  => $row[3],
            'field_3'  => $row[4],
            'field_4'  => $row[5],
            'manager'  => $row[6],
            'id_status' => Status::where('name', $row[7])->first()->id,
            'commit' => $row[8],
            'user_info' => $row[9],
            'id_user' => session('user_id'),
            'id_admin' => session('id_admin'),
        ]);
    }
}
