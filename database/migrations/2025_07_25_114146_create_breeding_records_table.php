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
        Schema::create('breeding_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cattle_id')->constrained()->onDelete('cascade');
            $table->date('breeding_date');
            $table->string('breeding_method'); // AI, Natural, Embryo Transfer
            $table->string('sire_breed')->nullable();
            $table->date('expected_calving_date')->nullable();
            $table->date('actual_calving_date')->nullable();
            $table->boolean('pregnancy_confirmed')->nullable(); // true, false, null
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('breeding_records');
    }
};
