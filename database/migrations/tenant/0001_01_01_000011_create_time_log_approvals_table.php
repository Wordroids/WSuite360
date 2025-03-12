<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_log_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('time_log_id')->nullable();
            $table->unsignedBigInteger('break_log_id')->nullable();
            $table->unsignedBigInteger('manager_id');
            $table->enum('status', ['approved', 'rejected']);
            $table->text('reason')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('time_log_id')->references('id')->on('time_logs')->onDelete('cascade');
            $table->foreign('break_log_id')->references('id')->on('break_logs')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_log_approvals');
    }
};
