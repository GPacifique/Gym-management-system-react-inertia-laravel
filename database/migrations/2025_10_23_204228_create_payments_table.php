<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATIONSHIPS
            |--------------------------------------------------------------------------
            */

            $table->foreignId('business_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('member_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('subscription_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            /*
            |--------------------------------------------------------------------------
            | PAYMENT INFO
            |--------------------------------------------------------------------------
            */

            $table->decimal('amount', 10, 2);

            $table->string('payment_method')
                ->nullable();
            // cash, momo, card

            $table->string('transaction_id')
                ->nullable();

            $table->string('status')
                ->default('paid');
            // paid, pending, failed

            $table->text('note')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | DATE
            |--------------------------------------------------------------------------
            */

            $table->date('payment_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};