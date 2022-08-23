<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public $data = [
        [
            "name" => "adminTest",
            "email" => "adminTest@adminTest",
            "password" => "12345trewq",
            "phone_manager" => "1234",
            'role' => 'admin'
        ],
        [
            "name" => "userTest",
            "email" => "userTest@userTest",
            "password" => "12345",
            "phone_manager" => "4321",
            'role' => 'user'
        ],
    ];

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($this->data as $datum) {
            $user = User::create([
                'name' => $datum['name'],
                'email' => $datum['email'],
                'password' => Hash::make($datum['password']),
                'phone_manager' => $datum['phone_manager'],
            ]);
            $user->assignRole( $datum['role']);
        }

    }
}
