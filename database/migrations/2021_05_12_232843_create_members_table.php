<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('last', 100);
            $table->string('middle', 100)->nullable();
            $table->string('first', 100);
            $table->string('gender', 20);
            $table->string('is_adult', 10);
            $table->string('email', 255);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('phone_type', 50)->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->date('no_contact')->nullable();
            $table->date('bounce')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('members');
    }
}
