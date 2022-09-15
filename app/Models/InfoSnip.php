<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoSnip extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'ip_snip','name_provider','number_provider','login_snip','password_snip', 'id_trunk'
    ];

    public function trunk()
    {
        return $this->belongsTo(Trunk::class,'id_trunk','id');
    }
}
