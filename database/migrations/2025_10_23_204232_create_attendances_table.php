<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | MULTI GYM SUPPORT (IMPORTANT)
            |--------------------------------------------------------------------------
            */
            $table->foreignId('gym_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | MEMBER
            |--------------------------------------------------------------------------
            */
            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | CHECK IN / OUT
            |--------------------------------------------------------------------------
            */
            $table->timestamp('check_in_time')->nullable();
            $table->timestamp('check_out_time')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */
            $table->enum('status', [
                'present',
                'absent',
                'late',
            ])->default('present');

            /*
            |--------------------------------------------------------------------------
            | NOTES
            |--------------------------------------------------------------------------
            */
            $table->text('notes')->nullable();

            /*
            |--------------------------------------------------------------------------
            | RECORDED BY (STAFF)
            |--------------------------------------------------------------------------
            */
            $table->foreignId('recorded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | PERFORMANCE INDEXES (IMPORTANT FOR MULTI-GYM)
            |--------------------------------------------------------------------------
            */
            $table->index(['gym_id', 'member_id']);
            $table->index(['gym_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};