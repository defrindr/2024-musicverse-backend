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
        Schema::create('skill_categories', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('auditions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('skill_id')->references('id')->on('skill_categories');
            $table->timestamp('date');
            $table->text('description');
            $table->string('term');
            $table->text('contract');
            $table->enum('status', ['draft', 'registration', 'selection', 'completed']);
            $table->foreignId('created_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('audition_assesments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audition_id')->references('id')->on('auditions');
            $table->string('assesment');
            $table->integer('weight');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('audition_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audition_id')->references('id')->on('auditions');
            $table->foreignId('participant_id')->references('id')->on('users');
            $table->enum('status', ['registration', 'auditions', 'contract']);
            $table->integer('total_point')->default(0);
            $table->integer('rank')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('audition_participant_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audition_participant_id')->references('id')->on('audition_participants');
            $table->foreignId('assesment_point_id')->references('id')->on('audition_assesments');
            $table->integer('point');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audition_participant_points');
        Schema::dropIfExists('audition_participants');
        Schema::dropIfExists('audition_assesments');
        Schema::dropIfExists('auditions');
        Schema::dropIfExists('skill_categories');
    }
};
