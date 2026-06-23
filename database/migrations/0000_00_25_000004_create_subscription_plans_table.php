<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('gym_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('name');

            $table->text('description')->nullable();

            $table->decimal('price', 10, 2);

            $table->integer('duration');

            $table->string('duration_type')
                ->default('months');
            // days, months, years

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};