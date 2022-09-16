<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Trunk extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'sip_server', 'login', 'password'
    ];

    public static function updateTrunk(){
        foreach (Trunk::all() as $item){
            $item->login =  Hash::make($item->login);
            $item->save();
        }
    }
}
