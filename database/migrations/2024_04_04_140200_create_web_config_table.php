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
        Schema::create('web_configs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['color', 'text', 'image']);
            $table->string('name');
            $table->text('value');
            $table->timestamps();
        });

        Schema::create('web_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('web_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('href');
            $table->string('image');
            $table->string('alt');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_galleries');
        Schema::dropIfExists('web_testimonials');
        Schema::dropIfExists('web_services');
        Schema::dropIfExists('web_banners');
        Schema::dropIfExists('web_configs');
    }
};
