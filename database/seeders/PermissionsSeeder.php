<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class PermissionsSeeder extends Seeder
{
    public $data = [
        [
            'id'=> 1,
            "name" => "admin",
            "guard_name" => "web",
        ],
        [
            'id'=> 2,
            'name' => 'user',
            "guard_name" => "web",
        ],
        [
            'id'=> 3,
            'name' => 'super_admin',
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
                'id' => $datum['id'],
                'name' => $datum['name'],
                'guard_name' => $datum['guard_name'],
            ]);
        }

    }
}
