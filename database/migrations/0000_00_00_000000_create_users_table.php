<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

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
            $table->bigIncrements('id');
            $table->string('icon', 255)->default('/storage/img/user/default.png');
            $table->string('name', 30);
            $table->string('description', 60)->nullable();
            $table->string('sex', 6)->default('asex');
            $table->string('username', 12)->unique();
            $table->string('email', 60)->unique();
            $table->string('password');
            $table->string('type')->default('general');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('status', 10)->default('active');
            $table->bigInteger('added_by');
            $table->rememberToken();
            $table->timestamps();
        });
        User::create([
            'id' => 1,
            'icon' => '/storage/img/user/avatars/00000-000000000a.png',
            'name' => 'Admin',
            'description' => 'A default master administrator account',
            'username' => 'admin',
            'email' => 'admin@adminlte.io',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
            'type' => 'master admin',
            'added_by' => 1,
        ]);
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
