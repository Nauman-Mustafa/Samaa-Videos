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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag')->unique();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('major_category_id')->constrained('categories')->onDelete('restrict');
            $table->foreignId('minor_category_id')->constrained('categories')->onDelete('restrict');
            $table->string('asset_company')->nullable(); // Changed from asset_category
            $table->text('description');
            $table->string('model_no')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('condition')->default('Done');
            $table->string('status')->default('Active');
            $table->string('matching')->nullable(); // For Matching in FAR
            $table->string('new_location')->nullable(); // For New Location column
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
