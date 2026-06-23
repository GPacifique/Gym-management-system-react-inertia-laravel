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
        Schema::create('gym_trainers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gym_id')
                  ->constrained('gyms')
                  ->cascadeOnDelete();

            $table->foreignId('trainer_id')
                  ->constrained('trainers')
                  ->cascadeOnDelete();

            $table->foreignId('branch_id')
                  ->nullable()
                  ->constrained('branches')
                  ->nullOnDelete();

            $table->timestamps();

            $table->unique([
                'gym_id',
                'trainer_id',
                'branch_id'
            ], 'gym_trainer_branch_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_trainers');
    }
};