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
        Schema::create('gyms', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('email')->unique();
            $table->string('phone')->nullable();

            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();

            $table->string('logo')->nullable();

            $table->enum('status', ['active', 'inactive', 'suspended'])
                  ->default('active');
                  $table->foreignId('owner_id')
      ->nullable()
      ->constrained('users')
      ->nullOnDelete();
$table->foreignId('subscription_plan_id')
      ->nullable()
      ->constrained('saas_plans')
      ->nullOnDelete();

            $table->timestamp('subscription_expires_at')
                  ->nullable();

            $table->timestamps();

            $table->index(['status']);
            $table->index(['country', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gyms');
    }
};