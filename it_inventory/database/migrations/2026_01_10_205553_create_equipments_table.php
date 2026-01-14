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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->string('serial_number')->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->enum('status', ['available', 'assigned', 'broken', 'scrapped'])->default('available');
            $table->date('purchase_date');
            $table->integer('warranty_duration')->default(12); // en mois
            $table->date('warranty_expires_at')->nullable();
            $table->string('image_path')->nullable();
            $table->json('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
