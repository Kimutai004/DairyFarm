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
        Schema::create('milk_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cattle_id')->constrained()->onDelete('cascade');
            $table->date('production_date');
            $table->decimal('morning_milk', 8, 2)->default(0);
            $table->decimal('evening_milk', 8, 2)->default(0);
            $table->decimal('total_milk', 8, 2)->storedAs('morning_milk + evening_milk');
            $table->decimal('fat_content', 5, 2)->nullable();
            $table->decimal('protein_content', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['cattle_id', 'production_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milk_productions');
    }
};
