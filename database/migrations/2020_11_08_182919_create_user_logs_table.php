<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogsTable extends Migration
{
    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action_name');
            $table->string('payload');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_logs');
    }
}
