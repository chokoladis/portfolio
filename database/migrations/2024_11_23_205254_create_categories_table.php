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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name', 30);
            $table->string('code', 30);
            $table->boolean('active')->default(1);
            $table->smallInteger('sort')->default(100)->unsigned();

            $table->unsignedBigInteger('preview_id')->index('category_preview_idx')->nullable();
            $table->foreign('preview_id', 'category_preview_id_fk')
                ->references('id')->on('files');

            $table->string('entity_code', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
