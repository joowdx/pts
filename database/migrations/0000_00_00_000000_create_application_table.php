<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Application;

class CreateApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 20)->unique();
            $table->text('value');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        Application::create([
            'key' => 'APP NAME',
            'value' => 'PGITS Tabulation System',
        ]);
        Application::create([
            'key' => 'APP NAME SHORT',
            'value' => 'PGITS',
        ]);
        Application::create([
            'key' => 'DESCRIPTION',
            'value' => 'Tabulation System made with love by PGITS of UM Digos College',
        ]);
        Application::create([
            'key' => 'ICON',
            'value' => '/storage/img/config/AdminLTELogo.png',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_configurations');
    }
}
