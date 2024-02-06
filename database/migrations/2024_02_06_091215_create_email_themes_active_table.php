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
        Schema::create('email_themes_active', function (Blueprint $table) {
            $table->tinyInteger("process_id");
            $table->unsignedBigInteger("theme_type_id");
            $table->unsignedBigInteger("user_id");
            $table->timestamps();

            $table->foreign("theme_type_id")
                ->on("email_themes")
                ->references("id")
                ->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_themes_active');
    }
};