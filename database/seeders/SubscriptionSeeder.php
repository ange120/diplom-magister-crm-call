<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SubscriptionSeeder extends Seeder
{
    public $data = [
        [
            "id" => 1,
            "name" => "crm",
            "info_name" => "СРМ"
        ],
        [
            "id" => 2,
            "name" => "auto_redial",
            "info_name" => "Автодозвон"
        ],
    ];

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('subscriptions')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($this->data as $datum) {
            Subscription::create([
                'id' => $datum['id'],
                'name' => $datum['name'],
                'info_name' => $datum['info_name'],
            ]);
        }

    }
}
