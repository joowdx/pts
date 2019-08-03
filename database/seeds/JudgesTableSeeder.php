<?php

use Illuminate\Database\Seeder;

class JudgesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Judge::class, 25)->create();
    }
}
