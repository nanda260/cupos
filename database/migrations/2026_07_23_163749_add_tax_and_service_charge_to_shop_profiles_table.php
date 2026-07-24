<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shop_profiles', function (Blueprint $table) {
            $table->decimal('tax_percentage', 5, 2)->default(0)->after('receipt_footer');
            $table->decimal('service_charge_percentage', 5, 2)->default(0)->after('tax_percentage');
        });
    }

    public function down(): void
    {
        Schema::table('shop_profiles', function (Blueprint $table) {
            $table->dropColumn(['tax_percentage', 'service_charge_percentage']);
        });
    }
};