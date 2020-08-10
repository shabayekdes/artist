<?php

use App\Models\Portrait;
use Illuminate\Database\Seeder;

class PortraitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Portrait::class, 50)->create();

    }
}
