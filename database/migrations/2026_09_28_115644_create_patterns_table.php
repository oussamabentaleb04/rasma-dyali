<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patterns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 100)->nullable();
            $table->string('symmetry_type', 20); // 4-fold, 6-fold, 8-fold
            $table->string('base_shape', 30);    // star, diamond, knot, floral
            $table->json('colors');              // e.g. ["#1e3a8a", "#ffffff"]
            $table->unsignedTinyInteger('grid_density')->default(6);
            $table->boolean('is_public')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('likes_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patterns');
    }
};