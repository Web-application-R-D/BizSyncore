<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->enum('status', ['active', 'trial', 'suspended'])->default('active')->after('url');
            $table->enum('plan', ['small', 'medium', 'large'])->default('small')->after('status');
            $table->integer('users')->default(0)->after('plan');
            $table->integer('user_limit')->default(5)->after('users');
            $table->decimal('mrr', 10, 2)->default(0)->after('user_limit');
            $table->timestamp('joined_at')->nullable()->after('mrr');
            $table->string('vertical')->nullable()->after('joined_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['status', 'plan', 'users', 'user_limit', 'mrr', 'joined_at', 'vertical']);
        });
    }
};
