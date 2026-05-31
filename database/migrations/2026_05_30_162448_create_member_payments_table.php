<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gym_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('member_subscription_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->decimal('amount', 12, 2);

            $table->string('payment_method');

            $table->string('transaction_reference')
                ->nullable();

            $table->dateTime('payment_date');

            $table->enum('status', [
                'pending',
                'completed',
                'failed',
                'refunded'
            ])->default('completed');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};