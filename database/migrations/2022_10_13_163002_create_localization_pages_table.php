<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalizationPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keys_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_page')->constrained('bind_pages');
            $table->string('name_key');
        });

        Schema::create('localization_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_page')->constrained('bind_pages');
            $table->foreignId('id_languages')->constrained('languages');
            $table->foreignId('id_key_page')->constrained('keys_pages');
            $table->text('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localization_pages');
    }
}
