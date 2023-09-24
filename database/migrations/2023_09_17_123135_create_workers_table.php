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
            $table->foreign('user_id', 'workers_user_fk')->references('id')->on('users');
            $table->string('url_avatar');
            $table->string('phone');
            $table->text('about');
            $table->json('socials');
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
