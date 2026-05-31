<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('message');

            $table->enum('type', [
                'sms',
                'email',
                'in_app'
            ]);

            $table->boolean('is_read')
                ->default(false);

            $table->timestamp('sent_at')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_notifications');
    }
};