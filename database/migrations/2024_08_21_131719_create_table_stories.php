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
        Schema::create("categories", function(Blueprint $table) {
            $table->bigInteger("id")->primary()->autoIncrement();
            $table->string("name")->nullable();
        });

        Schema::create('stories', function (Blueprint $table) {
            $table->bigInteger("id")->primary()->autoIncrement();
            $table->bigInteger("categories_id")->nullable();
            $table->string("title")->nullable();
            $table->string("author")->nullable();
            $table->longText("synopsis")->nullable();
            $table->string("cover_image")->nullable();
            $table->enum("status", ["draft", "publish"])->nullable();
            $table->timestamp("created_at")->nullable();
            $table->timestamp("updated_at")->nullable();

            $table->foreign("categories_id")->references("id")->on("categories");
        });

        Schema::create("chapters", function(Blueprint $table) {
            $table->bigInteger("id")->primary()->autoIncrement();
            $table->bigInteger("stories_id")->nullable();
            $table->string("title", 100)->nullable();
            $table->longText("story")->nullable();

            $table->timestamp("created_at")->nullable();
            $table->timestamp("updated_at")->nullable();

            $table->foreign("stories_id")->references("id")->on("stories");
        });

        Schema::create("keywords", function(Blueprint $table)  {
            $table->bigInteger("id")->primary()->autoIncrement();
            $table->bigInteger("stories_id")->nullable();
            $table->string("name")->nullable();

            $table->foreign("stories_id")->references("id")->on("stories");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keywords');
        Schema::dropIfExists('chapters');
        Schema::dropIfExists('stories');
        Schema::dropIfExists('categories');
    }
};
