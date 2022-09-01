<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trunk extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'sip_server', 'login', 'password'
    ];
}
