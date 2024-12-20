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
        Schema::create('project_remarks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('project_detail_id')
                ->nullable()
                ->constrained('project_details')
                ->onDelete('cascade');
            $table->text('remark');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_remarks');
    }
};
