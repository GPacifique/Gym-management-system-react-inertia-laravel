<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('membership_plan_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');

            $table->enum('status', [
                'active',
                'expired',
                'cancelled',
                'suspended'
            ])->default('active');

            $table->enum('payment_status', [
                'pending',
                'paid',
                'partial',
                'failed'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_subscriptions');
    }
};