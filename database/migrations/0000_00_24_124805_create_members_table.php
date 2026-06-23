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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('scan_code')->unique()->nullable();
            $table->foreignId('gym_id')
                  ->constrained('gyms')
                  ->cascadeOnDelete();

            $table->foreignId('branch_id')
                  ->nullable()
                  ->constrained('branches')
                  ->nullOnDelete();

            $table->string('member_number')->unique();

            $table->string('first_name');
            $table->string('last_name');

            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
                'suspended',
                'expired'
            ])->default('active');

            $table->timestamps();

            $table->index('gym_id');
            $table->index('branch_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};