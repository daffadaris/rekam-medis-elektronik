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
        Schema::create('medication_request_insurance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('med_req_id');
            $table->index('med_req_id');
            $table->foreign('med_req_id')->references('id')->on('medication_request')->onDelete('cascade');
            $table->string('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medication_request_insurance');
    }
};
