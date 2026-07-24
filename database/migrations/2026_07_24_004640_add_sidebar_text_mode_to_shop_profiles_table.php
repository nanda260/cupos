<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shop_profiles', function (Blueprint $table) {
            $table->string('sidebar_text_mode', 5)->default('light')->after('sidebar_color');
        });
    }

    public function down(): void
    {
        Schema::table('shop_profiles', function (Blueprint $table) {
            $table->dropColumn('sidebar_text_mode');
        });
    }
};