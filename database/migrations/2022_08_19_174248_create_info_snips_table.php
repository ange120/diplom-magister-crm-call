<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoSnipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_snips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_snip');
            $table->string('name_provider');
            $table->string('number_provider');
            $table->string('login_snip');
            $table->string('password_snip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_snips');
    }
}
