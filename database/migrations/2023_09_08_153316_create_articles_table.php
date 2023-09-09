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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 512);
            $table->string('multimedia_url', 512);
            $table->string('except', 512);
            $table->string('url', 512);
            $table->date('published_at');

            // Source
            $table->unsignedBigInteger('source_id');
            $table->foreign('source_id')
                  ->references('id')
                  ->on('sources');

            // Category
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
