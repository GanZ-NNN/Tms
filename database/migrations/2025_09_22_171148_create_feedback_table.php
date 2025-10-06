<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('session_id')->constrained('training_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Demographics
            $table->string('sex')->nullable();
            $table->string('sex_other')->nullable();
            $table->string('age')->nullable();

            // Ratings stored as JSON
            $table->json('speakers')->nullable();
            $table->json('content')->nullable();
            $table->json('staff')->nullable();
            $table->json('faculty_related')->nullable();

            // Overall ratings
            $table->tinyInteger('overall')->nullable();
            $table->tinyInteger('pre_knowledge')->nullable();
            $table->tinyInteger('post_knowledge')->nullable();

            // Communication preferences
            $table->string('want_news')->nullable();
            $table->json('news_channels')->nullable();
            $table->string('news_channels_other')->nullable();

            // Future topics
            $table->json('future_topics')->nullable();
            $table->string('future_topics_other')->nullable();

            // Activity preferences
            $table->string('participated_before')->nullable();
            $table->string('activity_format')->nullable();
            $table->string('activity_format_other')->nullable();

            // Influence factors
            $table->string('instructor_info_influence')->nullable();
            $table->string('outside_hours_influence')->nullable();

            // Comments
            $table->text('comment')->nullable();

            // Timestamp
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->unique(['session_id','user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
