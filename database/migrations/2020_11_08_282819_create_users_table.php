<?php

use App\Role;
use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->text('avatar')->nullable();
            $table->integer('role_id');
            $table->timestamps();
        });

        $user = new User;
        $user->name = 'Abdallah';
        $user->email = 'abdallah@gmail.com';
        $user->password = Hash::make('123456789');
        $user->role_id = Role::where('name', 'super_admin')->first()->id;
        $user->save();
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
