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

        Schema::create('web_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle');
            $table->string('description');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('web_services', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('web_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->string('content');
            $table->timestamps();
        });

        Schema::create('web_galleries', function (Blueprint $table) {
            $table->id();
            $table->integer('width')->comment('in percent');
            $table->string('image');
            $table->string('alt');
            $table->timestamps();
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
