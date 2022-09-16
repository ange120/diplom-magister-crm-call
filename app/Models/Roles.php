<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Roles extends Model
{
    use HasFactory;

    public static function updateRole(){
        foreach (Roles::all() as $item){
            $item->name =  Hash::make($item->name);
            $item->save();
        }
    }
}
