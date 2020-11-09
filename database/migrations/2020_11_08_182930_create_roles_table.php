<?php

use App\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Role::insert(['title' => 'Super admin', 'name' => 'super_admin']);
        Role::insert(['title' => 'Employee', 'name' => 'employee']);
        Role::insert(['title' => 'Customer', 'name' => 'customer']);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
