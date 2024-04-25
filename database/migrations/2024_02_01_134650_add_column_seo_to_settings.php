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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('seo_keywords_home')->nullable()->after('header_text');
            $table->string('seo_description_home')->nullable()->after('header_text');
            $table->string('seo_keywords_articles')->nullable()->after('header_text');
            $table->string('seo_description_articles')->nullable()->after('header_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};