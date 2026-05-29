<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up(): void
 { 
Schema::create('members', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->string('profile_photo')->nullable();
    $table->string('name');
    $table->string('email')->nullable();
    $table->string('phone')->nullable();

    $table->enum('status', ['active', 'inactive'])->default('active');

    $table->date('join_date')->nullable();
    $table->date('expiry_date')->nullable();

    $table->foreignId('gym_id')->nullable()->constrained()->nullOnDelete();

    $table->timestamps();
});
    }
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};