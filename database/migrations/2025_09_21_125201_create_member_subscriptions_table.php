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
        Schema::create('member_subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gym_id')
                  ->constrained('gyms')
                  ->cascadeOnDelete();

            $table->foreignId('member_id')
                  ->constrained('members')
                  ->cascadeOnDelete();

            $table->foreignId('membership_plan_id')
                  ->constrained('membership_plans')
                  ->cascadeOnDelete();

            $table->date('start_date');

            $table->date('end_date');

            $table->enum('status', [
                'active',
                'expired',
                'cancelled',
                'pending'
            ])->default('active');

            $table->timestamps();

            $table->index('gym_id');
            $table->index('member_id');
            $table->index('membership_plan_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_subscriptions');
    }
};