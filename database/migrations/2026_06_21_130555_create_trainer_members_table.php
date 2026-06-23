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
        Schema::create('trainer_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trainer_id')
                  ->constrained('trainers')
                  ->cascadeOnDelete();

            $table->string('first_name');
            $table->string('last_name');

            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->timestamps();

            $table->index('trainer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_members');
    }
};