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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('session_id')->constrained('training_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Demographics
            $table->string('sex')->nullable();
            $table->string('age')->nullable();

            // Ratings stored as JSON
            $table->json('speakers')->nullable();
            $table->json('content')->nullable();
            $table->json('staff')->nullable();
            $table->tinyInteger('overall')->nullable();
            $table->tinyInteger('pre_knowledge')->nullable();
            $table->tinyInteger('post_knowledge')->nullable();

            // Suggestions and future topics
            $table->text('comment')->nullable();
            $table->json('future_topics')->nullable();

            // Timestamp
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->unique(['session_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
