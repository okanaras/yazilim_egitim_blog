<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug");
            $table->boolean("status")->default(0);
            $table->boolean("feature_status")->default(0);
            $table->string("description")->nullable();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->integer("order")->default(0);
            $table->string("seo_keywords")->nullable();
            $table->string("seo_description")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->timestamps();

            $table->foreign("parent_id")->references("id")->on("categories");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};