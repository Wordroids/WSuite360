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
        $columns = DB::select('SHOW COLUMNS FROM invoice_items');
        foreach ($columns as $column) {
            echo "Column: {$column->Field} | Type: {$column->Type} | Null: {$column->Null}\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
