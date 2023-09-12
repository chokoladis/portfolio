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
        Schema::table('menu_navs', function (Blueprint $table) {
            $table->string('role')->default('user')->after('link');
            $table->integer('sort')->default('100')->after('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_navs', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('sort');
        });
    }
};
