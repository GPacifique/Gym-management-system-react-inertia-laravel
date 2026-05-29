<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {

            $table->id();

            // User who performed action
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Related member
            $table->foreignId('member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Action title
            $table->string('action');

            // Detailed description
            $table->text('description')->nullable();

            // Status
            $table->enum('status', [
                'completed',
                'pending',
                'failed',
            ])->default('completed');

            // Module
            $table->string('module')->nullable();
            // payments, bookings, attendance etc

            // Extra JSON data
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};