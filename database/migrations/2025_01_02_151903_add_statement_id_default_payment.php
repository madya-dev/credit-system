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
        Schema::table('default_payments', function (Blueprint $table) {
            $table->foreignId('statement_id')->nullable()->constrained('credit_card_statements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('default_payments', function (Blueprint $table) {
            $table->dropColumn('statement_id');
        });
    }
};
