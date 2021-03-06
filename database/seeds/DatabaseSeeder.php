<?php

use \Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('NestedEntitiesTableSeeder');
        $this->command->info('NestedEntitiesTable seeded.');

        Eloquent::reguard();
    }
}
