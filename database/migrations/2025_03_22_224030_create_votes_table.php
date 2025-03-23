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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_id')->unique();
            $table->unsignedBigInteger('candidate_voted_id');
            $table->datetime('date')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('candidate_id')->references('id')->on('voters');
            $table->foreign('candidate_voted_id')->references('id')->on('voters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
