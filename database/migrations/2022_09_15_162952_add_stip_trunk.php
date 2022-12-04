<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStipTrunk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('info_snips', 'id_trunk'))
        {
            Schema::table('info_snips', function (Blueprint $table) {
                $table->foreignId('id_trunk')->constrained('trunks')->onDelete('cascade');
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
        //
    }
}
