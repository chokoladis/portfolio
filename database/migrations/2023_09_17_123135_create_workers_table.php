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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->index('user_id', 'workers_user_idx');
            $table->foreign('user_id', 'workers_user_fk')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->string('code', 40)->unique()->index();
            $table->string('url_avatar', 512)->nullable();
            $table->string('phone', 20);
            $table->string('about', 1024)->nullable();
            $table->json('socials')->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
