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
        Schema::create('service_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Service\Service::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Dropdown\Dropdown::class)->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->string('whatsapp');
            $table->string('date');
            $table->string('time');
            $table->string('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_forms');
    }
};
