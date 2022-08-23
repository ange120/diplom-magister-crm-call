<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_subscription')->constrained('subscriptions');
            $table->foreignId('id_user')->constrained('users');
            $table->date('date_start_subscriptions');
            $table->date('date_end_subscriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions_users');
    }
}
