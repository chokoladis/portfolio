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
        Schema::create('example_works_stats', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('work_id');
            $table->index('work_id', 'example_works_work_idx');
            $table->foreign('work_id', 'example_works_example_works_stats_fk')
                ->references('id')->on('example_works')
                ->onDelete('cascade');

            $table->integer('view_count')->default(0);
            $table->timestamp('viewed_admin_at')->nullable();
            $table->timestamps();
        });

        Schema::create('workers_stats', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('worker_id');
            $table->index('worker_id', 'workers_worker_idx');
            $table->foreign('worker_id', 'workers_workers_stats_fk')
                ->references('id')->on('workers')
                ->onDelete('cascade');

            $table->integer('view_count')->default(0);
            $table->timestamp('viewed_admin_at')->nullable();
            $table->timestamps();
        });

        Schema::create('feedback_stats', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('feedback_id');
            $table->index('feedback_id', 'feedback_feedback_idx');
            $table->foreign('feedback_id', 'feedback_feedback_stats_fk')
                ->references('id')->on('feedback')
                ->onDelete('cascade');

            $table->timestamp('viewed_admin_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('example_works_stats');
        Schema::dropIfExists('workers_stats');
        Schema::dropIfExists('feedback_stats');
    }
};
