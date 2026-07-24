<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shop_profiles', function (Blueprint $table) {
            // Warna aksen utama (tombol, link aktif, focus ring)
            $table->string('primary_color', 7)->default('#EF9F2E')->after('service_charge_percentage');
            // Warna dasar panel sidebar & panel login
            $table->string('sidebar_color', 7)->default('#1C1710')->after('primary_color');
        });
    }

    public function down(): void
    {
        Schema::table('shop_profiles', function (Blueprint $table) {
            $table->dropColumn(['primary_color', 'sidebar_color']);
        });
    }
};