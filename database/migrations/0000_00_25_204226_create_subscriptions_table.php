<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {

    $table->id();

    $table->foreignId('gym_id')
        ->constrained()
        ->onDelete('cascade');

    $table->foreignId('member_id')
        ->constrained()
        ->onDelete('cascade');

    $table->foreignId('subscription_plan_id')
        ->constrained()
        ->onDelete('cascade');

    $table->date('start_date');

    $table->date('end_date');

    $table->boolean('is_active')
        ->default(true);

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};