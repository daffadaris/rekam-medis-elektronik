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
        Schema::create('encounter_diagnosis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('encounter_id');
            $table->index('encounter_id');
            $table->foreign('encounter_id')->references('id')->on('encounter')->onDelete('cascade');
            $table->string('condition');
            $table->enum('use', ['AD', 'DD', 'CC', 'CM', 'pre-op', 'post-op', 'billing'])->nullable();
            $table->unsignedInteger('rank')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encounter_diagnosis');
    }
};
