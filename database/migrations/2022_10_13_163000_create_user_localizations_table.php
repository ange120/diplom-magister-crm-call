<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLocalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('languages')){
            Schema::create('languages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('short_name');
            });
        }
        if(!Schema::hasTable('user_localizations')){
            Schema::create('user_localizations', function (Blueprint $table) {
                $table->id();
                $table->string('email')->index();
                $table->foreignId('id_languages')->constrained('languages');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_localizations');
    }
}
