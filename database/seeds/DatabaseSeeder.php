<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PortraitSeeder::class);
        $this->call(AttributesSeeder::class);
        $this->call(AttributeValuesSeeder::class);
    }
}
