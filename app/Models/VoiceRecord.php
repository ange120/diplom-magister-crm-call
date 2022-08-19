<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoiceRecord extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'text', 'id_language'
    ];
    public function languages()
    {
        return $this->belongsTo(Language::class);
    }
}
