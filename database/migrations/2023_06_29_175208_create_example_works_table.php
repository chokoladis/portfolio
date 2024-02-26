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
        Schema::create('example_works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id', 'example_work_user_idx');
            $table->foreign('user_id', 'example_work_user_fk')
                ->references('id')->on('users');
            $table->string('slug', 70)->unique()->index();
            $table->string('title', 70);
            $table->string('description', 1500)->nullable();
            $table->string('url_files', 1500)->nullable();
            $table->string('url_work', 40)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('example_works');
    }
};
