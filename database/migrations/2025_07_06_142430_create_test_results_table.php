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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_session_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('score_listening');
            $table->integer('score_structure');
            $table->integer('score_reading');
            $table->integer('total_score');
            $table->enum('status', ['LULUS', 'TIDAK LULUS']);
            $table->string('certificate_id')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
