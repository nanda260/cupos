<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shop_profiles', function (Blueprint $table) {
            // Warna latar belakang utama aplikasi (di luar kartu putih),
            // dipakai baik di halaman admin maupun halaman login.
            $table->string('body_color', 7)->default('#DAD4C6')->after('sidebar_text_mode');
        });
    }

    public function down(): void
    {
        Schema::table('shop_profiles', function (Blueprint $table) {
            $table->dropColumn('body_color');
        });
    }
};