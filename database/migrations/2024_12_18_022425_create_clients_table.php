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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('sex', ['male', 'female']);
            $table->foreignId('education_id')->references('id')->on('educations')->onDelete('cascade');
            $table->foreignId('marriage_id')->references('id')->on('marriages')->onDelete('cascade');
            $table->integer('age');
            $table->decimal('limit_bal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
