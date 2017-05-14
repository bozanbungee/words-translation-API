<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');


        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        \App\Translate::truncate();

        factory(\App\Translate::class, 100)->create();
        // Enable it back
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
