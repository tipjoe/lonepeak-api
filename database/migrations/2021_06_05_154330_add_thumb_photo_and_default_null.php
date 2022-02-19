<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddThumbPhotoAndDefaultNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update("update users set photo = null;");

        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->default(null)->change();
            $table->string('photo_thumb')->nullable()->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update("update users set photo = 'default.jpg';");

        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->default('default.jpg')->change();
            $table->dropColumn('photo_thumb');
        });
    }
}
