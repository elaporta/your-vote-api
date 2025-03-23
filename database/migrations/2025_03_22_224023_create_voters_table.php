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
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 255);
            $table->string('last_name', length: 255);
            $table->string('document', length: 8)->unique();
            $table->date('dob');
            $table->string('address', length: 255);
            $table->string('phone', length: 255);
            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->boolean('is_candidate')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
