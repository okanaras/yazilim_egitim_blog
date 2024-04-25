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
        Schema::create('email_themes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("theme_type");
            $table->tinyInteger("process");
            $table->json("body");
            $table->unsignedBigInteger("user_id");
            $table->boolean("status")->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_themes');
    }
};