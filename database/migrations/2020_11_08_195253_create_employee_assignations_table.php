<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAssignationsTable extends Migration
{
    public function up()
    {
        Schema::create('employee_assignations', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('customer_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_assignations');
    }
}
