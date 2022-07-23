<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('statuses', function (Blueprint $table) {
//            $table->id();
//            $table->string('name');
//        });

        Schema::create('base_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_client');
            $table->string('phone');
            $table->string('field_1')->nullable();
            $table->string('field_2')->nullable();
            $table->string('field_3')->nullable();
            $table->string('field_4')->nullable();
            $table->string('manager')->nullable();
            $table->foreignId('id_status')->constrained('statuses');
            $table->string('commit')->nullable();
            $table->string('user_info')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('sex')->nullable();
            $table->date('birthday')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_infos');
    }
}
