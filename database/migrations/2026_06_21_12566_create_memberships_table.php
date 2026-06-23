<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {

            $table->id();

            // 🔐 Multi-tenant (SaaS isolation)
            $table->foreignId('gym_id')
                ->constrained('gyms')
                ->cascadeOnDelete();

            // 👤 Member relationship
            $table->foreignId('member_id')
                ->constrained('members')
                ->cascadeOnDelete();

            // 📦 Plan relationship
            $table->foreignId('membership_plan_id')
                ->constrained('membership_plans')
                ->restrictOnDelete();

            // 📅 Duration
            $table->date('start_date');
            $table->date('end_date');

            // 💰 Pricing snapshot (important for history integrity)
            $table->decimal('amount', 10, 2)->default(0);

            // 📊 Status
            $table->enum('status', [
                'active',
                'expired',
                'frozen',
                'pending',
                'cancelled'
            ])->default('pending');

            // 📝 Optional notes
            $table->text('notes')->nullable();

            // 👨‍💼 Who created it (receptionist/manager/admin)
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            /*
            |--------------------------------------------
            | Indexes (important for performance at scale)
            |--------------------------------------------
            */
            $table->index(['gym_id']);
            $table->index(['member_id']);
            $table->index(['membership_plan_id']);
            $table->index(['status']);
            $table->index(['end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};