<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            // 🔗 link to business
            $table->foreignId('business_id')
                ->constrained()
                ->onDelete('cascade');

            // Branch info
            $table->string('name');
            $table->string('code')->nullable(); // optional branch code

            // Location
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();

            // Contact
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};