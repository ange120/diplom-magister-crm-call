<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public $data = [
        [
            "id" => 1,
            "name" => "В работе1"
        ],
        [
            "id" => 2,
            "name" => "Необработанный"
        ],
        [
            "id" => 3,
            "name" => "Недозвон"
        ],
        [
            "id" => 4,
            "name" => "Сделана продажа"
        ],
    ];

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('statuses')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($this->data as $datum) {
            Status::create([
                'id' => $datum['id'],
                'name' => $datum['name'],
            ]);
        }

    }
}
