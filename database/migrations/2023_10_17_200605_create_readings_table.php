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
        Schema::create('readings', function (Blueprint $table) {
            $table->id();
            $table->string('source_id')->nullable();
            $table->integer('flow')->nullable();
            $table->integer('accumulative_flow')->nullable();
            $table->integer('status')->nullable();
            $table->integer('pressure')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('standby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readings');
    }
};
