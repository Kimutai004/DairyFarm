<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('sale_date');
            $table->enum('sale_type', ['milk', 'cattle', 'other']);
            $table->foreignId('cattle_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('quantity', 8, 2)->nullable(); // liters for milk
            $table->decimal('price_per_unit', 8, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('buyer_name');
            $table->string('buyer_contact')->nullable();
            $table->text('description')->nullable();
            $table->enum('payment_status', ['pending', 'partial', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
