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
        Schema::create('cattle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tag_number')->unique();
            $table->string('name');
            $table->enum('breed', ['Holstein', 'Jersey', 'Guernsey', 'Ayrshire', 'Brown Swiss', 'Shorthorn', 'Other']);
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->decimal('weight', 8, 2)->nullable();
            $table->enum('status', ['active', 'sold', 'deceased', 'dry'])->default('active');
            $table->string('color')->nullable();
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
        Schema::dropIfExists('cattle');
    }
};
