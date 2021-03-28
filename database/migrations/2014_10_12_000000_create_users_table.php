<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->index();
            $table->string('email', 200)->index()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->smallInteger('login_attempts')->default(0);
            $table->string('status', 10)->index()->default('IN-ACTIVE'); //ACTIVE, IN-ACTIVE, DISABLED, LOCKED
            $table->string('password', 255);
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->string('contact_no', 20)->index();
            $table->rememberToken();
            $table->unsignedBigInteger('role_id')->index();
            $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('users');
    }
}
