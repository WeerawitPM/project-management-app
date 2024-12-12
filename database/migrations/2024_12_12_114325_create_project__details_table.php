<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('project_head_id')
                ->nullable()
                ->constrained('project_heads')
                ->onDelete('cascade');
            $table->foreignId('project_phase_id')
                ->nullable()
                ->constrained('project_phases')
                ->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('status_id')
                ->nullable()
                ->constrained('project_detail_statuses')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_details');
    }
};
