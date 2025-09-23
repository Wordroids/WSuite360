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
        Schema::table('employees', function (Blueprint $table) {
            // Remove the old string column if exists
            if (Schema::hasColumn('employees', 'designation')) {
                $table->dropColumn('designation');
            }

            // Add the foreign key if not exists
            if (!Schema::hasColumn('employees', 'designation_id')) {
                $table->foreignId('designation_id')
                    ->nullable()
                    ->constrained('designations')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('designation')->nullable();
            $table->dropForeign(['designation_id']);
            $table->dropColumn('designation_id');
        });
    }
};
