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
        Schema::create('transformations', function (Blueprint $table) {
            $table->id();
            $table->string('transformation_type', 100)->index();
            $table->text('input_text');
            $table->text('output_text');
            $table->string('user_ip', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();
            
            $table->index(['transformation_type', 'created_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transformations');
    }
};