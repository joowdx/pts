<?php

use Illuminate\Database\Seeder;

class ContestantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Contestant::class, 25)->create();
    }
}
