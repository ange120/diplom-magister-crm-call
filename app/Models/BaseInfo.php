<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Status;
use Illuminate\Support\Facades\Hash;

class BaseInfo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_client', 'phone', 'field_1', 'field_2', 'field_3','field_4','manager','id_status',  'id_user', 'commit', 'user_info',
        'country', 'city', 'sex', 'birthday', 'id_admin'
    ];
    public static function updateInfo(){
        foreach (BaseInfo::all() as $item){
            $item->phone =  Hash::make($item->phone);
            $item->id_client =  rand(0, 50000);
            $item->save();
        }
    }
}
