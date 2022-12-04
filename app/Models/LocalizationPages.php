<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalizationPages extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id_page', 'id_languages', 'id_key_page', 'keys_pages', 'text'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'id');
    }
}
