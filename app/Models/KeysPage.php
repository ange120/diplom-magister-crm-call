<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeysPage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id_page', 'name_key'
    ];
}
