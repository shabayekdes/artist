<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'phone' => '+201097072480',
            'password' => bcrypt('12345678'),
            'type' => 'admin'

        ]);
        
        factory(User::class, 10)->create();
    }
}
