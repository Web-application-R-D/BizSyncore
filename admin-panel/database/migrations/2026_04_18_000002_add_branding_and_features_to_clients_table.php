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
            $table->string('business_type')->nullable()->after('vertical');
            $table->string('country')->nullable()->default('Sri Lanka')->after('business_type');
            $table->string('display_name')->nullable()->after('country');
            $table->string('primary_color')->nullable()->default('#1E2A5E')->after('display_name');
            $table->string('accent_color')->nullable()->default('#F59E0B')->after('primary_color');
            $table->string('logo_url')->nullable()->after('accent_color');
            $table->string('pos_api_base_url')->nullable()->after('logo_url');
            $table->json('feature_flags')->nullable()->default(json_encode([
                'advanced_reporting' => false,
                'multi_outlet_support' => false,
                'api_access' => false,
            ]))->after('pos_api_base_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'business_type',
                'country',
                'display_name',
                'primary_color',
                'accent_color',
                'logo_url',
                'pos_api_base_url',
                'feature_flags',
            ]);
        });
    }
};
