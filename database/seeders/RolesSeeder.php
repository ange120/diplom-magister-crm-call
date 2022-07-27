<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class RolesSeeder extends Seeder
{
    public $data = [
        [
            "name" => "admin",
            "guard_name" => "web",
        ],
        [
            'name' => 'user',
            "guard_name" => "web",
        ],
    ];

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('statuses')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($this->data as $datum) {
            Roles::create([
                'name' => $datum['name'],
                'guard_name' => $datum['guard_name'],
            ]);
        }

    }
}
