<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // who made the booking
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // booking details
            $table->string('service'); // e.g. PT session, class, sauna
            $table->date('date');
            $table->time('time');

            // status workflow
            $table->string('status')->default('pending');
            // pending | confirmed | cancelled | completed

            // optional notes
            $table->text('notes')->nullable();

            // optional tracking (useful for gym SaaS scaling)
            $table->foreignId('gym_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();

            // indexes for performance
            $table->index(['date', 'time']);
            $table->index('status');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};