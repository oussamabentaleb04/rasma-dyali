<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pattern_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pattern_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // One like per user per pattern, enforced by the database itself
            $table->unique(['pattern_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pattern_likes');
    }
};