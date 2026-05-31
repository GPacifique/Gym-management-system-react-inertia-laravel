<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_subscription_renewals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_subscription_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('renewal_date');

            $table->date('old_end_date');
            $table->date('new_end_date');

            $table->decimal('amount', 12, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_renewals');
    }
};