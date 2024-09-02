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
        Schema::create('optimizers', function (Blueprint $table) {
            $table->id();
            $table->timestamp('process_id')->default(null)->nullable();
            $table->string('model_name', 30);
            $table->integer('model_id');
            $table->string('path', 60);
            $table->timestamp('start_generate_at')->default(null)->nullable();
            $table->boolean('is_optimize')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optimizers');
    }
};
