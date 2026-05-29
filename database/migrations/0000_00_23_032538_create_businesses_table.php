<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('name');
            $table->string('slug')->unique()->nullable();

            // Branding
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();

            // Contact info
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();

            // Location
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();

            // Business details
            $table->text('description')->nullable();
            $table->string('type')->nullable(); 
            // e.g gym, spa, swimming, wellness, sport club

            // Status
            $table->boolean('is_active')->default(true);

            // Optional rating / analytics (future use)
            $table->decimal('rating', 3, 2)->default(0);

            // Soft delete support
            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};