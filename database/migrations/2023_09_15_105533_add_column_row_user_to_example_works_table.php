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
        Schema::table('example_works', function (Blueprint $table) {
            
            // $table->dropColumn('user_id');
            // $table->dropColumn('user');

            // $table->integer('user_id')->unsigned();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id', 'example_work_user_idx');
            $table->foreign('user_id', 'example_work_user_fk')->references('id')->on('users');
            // $table->index('user', 'example_works_users_idx');
            // $table->foreign('user', 'example_works_users_fk')->on('users')->references('name');            
            // $table->foreignId('user')->constrained()->cascadeOnDelete();
        });

        Schema::table('example_works', function (Blueprint $table) {
            // $table->foreign('user_id', 'example_work_user_fk')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('example_works', function (Blueprint $table) {
            // $table->dropForeign('user');
            // $table->dropIndex('user');
            $table->dropColumn('user_id');
            // $table->dropIfExists('example_works');
        });
    }
};
