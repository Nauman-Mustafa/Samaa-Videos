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
        Schema::create('task_phases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order_index')->default(0);
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('color', 7)->default('#007bff');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_final')->default(false); // Marks the completion phase
            $table->timestamps();

            $table->index(['order_index', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_phases');
    }
}; 