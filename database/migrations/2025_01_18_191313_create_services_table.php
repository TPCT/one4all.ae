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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Admin::class)->index()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->boolean('promote_to_homepage')->default(false);
            $table->boolean('status')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('services_lang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->index()->references('id')->on('companies')->cascadeOnDelete();
            $table->string('language', 10)->index()->nullable(false);
            $table->string('title')->nullable(false);
            $table->string('price')->nullable();
            $table->string('description')->nullable(false);
            $table->text('content')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
