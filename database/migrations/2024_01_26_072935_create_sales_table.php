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
        Schema::create('sales', function (Blueprint $table) {
            $table->id()->comment('Unique identifier for each sale record');
            $table->tinyInteger('status')->unsigned()->default(1)->comment('Status of the sale (e.g., active, inactive)');
            $table->string('ref_num', 50)->comment('Reference number for the sale');
            $table->date('invoice_date')->comment('Date when the invoice was generated');
            $table->date('delivery_date')->nullable()->comment('Date when the delivery is scheduled, if applicable');
            $table->string('payee')->comment('Name of the payee associated with the sale');
            $table->mediumInteger('payee_id')->comment('Identifier for the payee');
            $table->decimal('total', 12, 2)->comment('Total amount of the sale');
            $table->string('currency', 3)->nullable()->comment('Currency code for the sale amount');
            $table->decimal('currency_total', 12, 2)->comment('Total amount in the specified currency');
            $table->decimal('paid', 12, 2)->comment('Amount paid for the sale');
            $table->decimal('due', 12, 2)->comment('Remaining amount to be paid');
            $table->decimal('rounding', 3, 2)->default(0.00)->comment('Rounding amount for the sale');
            $table->date('due_date')->nullable()->comment('Due date for payment, if applicable');
            $table->string('attn', 200)->nullable()->comment('Attention field for additional information');
            $table->string('payment_term', 20)->nullable()->comment('Payment terms for the sale');
            $table->tinyInteger('payment_status')->default(0)->comment('Status of payment (e.g., pending, completed)');
            $table->tinyInteger('delivery_status')->default(0)->comment('Status of delivery (e.g., pending, completed)');
            $table->integer('branch_id')->default(0)->comment('Branch identifier associated with the sale');
            $table->tinyInteger('locked')->default(0)->comment('Lock status for preventing modifications');
            $table->smallInteger('staff_id')->nullable()->comment('Staff identifier associated with the sale');
            $table->timestamps(); //'Timestamps for record creation and updates';
            $table->softDeletes()->comment('Soft delete column for handling deleted records');
            $table->smallInteger('author_id')->nullable()->comment('Author identifier associated with the sale');

            // Indexes
            $table->index('currency', 'sales_currency_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
