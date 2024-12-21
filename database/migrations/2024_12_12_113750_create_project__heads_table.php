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
        Schema::create('project_heads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->foreignId('company_id')
                ->nullable()
                ->constrained('companies')
                ->nullOnDelete();
            $table->foreignId('assign_id')
                ->nullable()
                ->constrained('assigns')
                ->nullOnDelete();
            $table->foreignId('status_id')
                ->nullable()
                ->constrained('project_statuses')
                ->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('images')->nullable();
            $table->string('request_by')->nullable();
            $table->string('logo')->nullable();
            $table->foreignId('status_new_old_id')
                ->nullable()
                ->constrained('project_status_new_olds')
                ->nullOnDelete();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_heads');
    }
};
