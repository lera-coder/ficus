<?php

namespace Database\Seeders;

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

        $this->call(
            [
                NetworkSeeder::class,
                UserSeeder::class,
                PhoneCountryCodeSeeder::class,
                PhoneSeeder::class,
                RoleSeeder::class,
                EmailSeeder::class,
                Token2faSeeder::class
            ]
        );
    }
}
