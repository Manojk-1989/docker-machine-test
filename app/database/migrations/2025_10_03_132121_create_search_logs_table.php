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
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('total_results')->default(0);
            $table->json('results_breakdown')->nullable(); // Store counts per model type
            $table->integer('page')->default(1);
            $table->integer('per_page')->default(10);
            $table->decimal('response_time', 8, 2)->nullable(); // in milliseconds
            $table->timestamps();
            
            // Indexes for performance
            $table->index('query');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_logs');
    }
};
