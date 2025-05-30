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
        Schema::create('header_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Admin::class)->index()->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->text('image');
            $table->text('title');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_images');
    }
};
