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
        Schema::create('consolidates', function (Blueprint $table) {
            $table->id();
            $table->date('date_consolidate');
            $table->integer('pvc');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('areacustomer_id')->constrained('areacustomers')->onDelete('cascade');
            $table->string('reported_and_unreported')->nullable();
            $table->string('remarks')->nullable();
            $table->date('date_receipt')->nullable();
            $table->string('receipt_invoice')->nullable();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->string('tin')->nullable();
            $table->string('type');
            $table->foreignId('expensescategory_id')->nullable()->constrained('expensescategories')->nullOnDelete();
            $table->foreignId('nonexpensescategory_id')->nullable()->constrained('nonexpensescategories')->nullOnDelete();
            $table->decimal('net_vat', 12, 2)->nullable();
            $table->decimal('input_vat', 12, 2)->nullable();
            $table->decimal('non_vat', 12, 2)->nullable();
            $table->decimal('ewt', 12, 2)->nullable();
            $table->decimal('gross_amt', 12, 2)->storedAs('net_vat + input_vat + non_vat - ewt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consolidates');
    }
};
