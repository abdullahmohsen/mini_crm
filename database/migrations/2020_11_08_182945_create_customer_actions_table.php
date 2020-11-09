<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerActionsTable extends Migration
{
    public function up()
    {
        Schema::create('customer_actions', function (Blueprint $table) {
            $table->id();
            $table->string('action_name');
            $table->text('record');
            $table->integer('customer_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_actions');
    }
}
