<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BindPages extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name_page', 'url_page'
    ];
}
