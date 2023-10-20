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
        Schema::create('procedure_item_used', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('procedure_id');
            $table->index('procedure_id');
            $table->foreign('procedure_id')->references('id')->on('procedure')->onDelete('cascade');
            $table->string('system')->nullable();
            $table->string('code')->nullable();
            $table->string('display')->nullable();
            $table->string('reference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedure_item_used');
    }
};
