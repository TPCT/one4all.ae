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
        Schema::create('client_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Dropdown\Dropdown::class)->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('paid')->default(false);
            $table->boolean('done')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_consultations');
    }
};
