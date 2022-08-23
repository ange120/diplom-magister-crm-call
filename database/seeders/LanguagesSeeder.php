<?php

namespace Database\Seeders;

use App\Models\Language;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class LanguagesSeeder extends Seeder
{
    public $data = [
        [
            "name" => "russian",
        ],
        [
            'name' => 'english',
        ],
    ];

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('languages')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($this->data as $datum) {
            Language::create([
                'name' => $datum['name'],
            ]);
        }

    }
}
