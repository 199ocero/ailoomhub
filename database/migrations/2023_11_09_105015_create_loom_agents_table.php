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
        Schema::create('loom_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->foreignId('ai_provider_id')->references('id')->on('ai_providers')->onDelete('cascade');
            $table->foreignId('ai_model_id')->references('id')->on('ai_models')->onDelete('cascade');
            $table->foreignId('knowledge_base_id')->references('id')->on('knowledge_bases')->onDelete('cascade');
            $table->string('system_message');
            $table->boolean('status')->default(true);
            $table->json('config_options')->nullable();
            $table->integer('usage_count')->default(0);
            $table->timestamp('last_used')->nullable();
            $table->text('token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loom_agents');
    }
};
