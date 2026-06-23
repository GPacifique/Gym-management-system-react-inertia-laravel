<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('membership_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gym_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('membership_id')->constrained()->cascadeOnDelete();

            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->default('cash'); // cash, card, momo, bank
            $table->string('status')->default('paid'); // paid, pending, failed

            $table->string('transaction_reference')->nullable();

            $table->date('payment_date');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['gym_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_payments');
    }
};