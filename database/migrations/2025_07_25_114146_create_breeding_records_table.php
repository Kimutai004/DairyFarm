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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cattle_id')->constrained()->onDelete('cascade');
            $table->date('breeding_date');
            $table->string('breeding_method')->default('artificial_insemination'); // artificial_insemination, natural
            $table->string('sire_info')->nullable();
            $table->date('expected_calving_date')->nullable();
            $table->date('actual_calving_date')->nullable();
            $table->enum('pregnancy_status', ['confirmed', 'not_confirmed', 'failed', 'completed'])->default('not_confirmed');
            $table->integer('gestation_period')->nullable(); // in days
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
