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
        Schema::create('saas_plans', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->decimal('price', 10, 2)->default(0);

            $table->enum('billing_cycle', [
                'monthly',
                'quarterly',
                'yearly',
                'lifetime'
            ])->default('monthly');

            $table->unsignedInteger('max_members')->default(0);
            $table->unsignedInteger('max_trainers')->default(0);
            $table->unsignedInteger('max_staff')->default(0);
            $table->unsignedInteger('max_branches')->default(1);

            $table->json('features')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saas_plans');
    }
};