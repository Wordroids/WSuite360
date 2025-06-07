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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');

            $table->string('invoice_number')->unique();
            $table->string('po/so_number')->nullable();

            $table->date('invoice_date');
            $table->date('due_date');

            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            $table->text('notes')->nullable();
            $table->text('instructions')->nullable();
            $table->text('footer')->nullable();

            $table->decimal('conversion_rate', 10, 4)->default(1.0000);
            $table->string('currency', 3)->default('USD'); // ISO 4217 currency code


            $table->enum('status', ['draft', 'sent', 'paid', 'overdue'])->default('draft');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
