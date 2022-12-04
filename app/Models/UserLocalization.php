<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocalization extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'email', 'id_languages'
    ];
}
