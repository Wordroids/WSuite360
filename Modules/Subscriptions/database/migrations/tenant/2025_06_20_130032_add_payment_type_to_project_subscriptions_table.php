<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::table('project_subscriptions', function (Blueprint $table) {
            $table->string('payment_type')->default('card')->after('billing_cycle');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down()
    {
        Schema::table('project_subscriptions', function (Blueprint $table) {
            $table->dropColumn('payment_type');
        });
    }
};
