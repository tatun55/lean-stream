<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OrganisationSeeder::class,
            StaffSeeder::class,
            ClientSeeder::class,
            MessageSeeder::class,
            RemarkSeeder::class,
            LineBotSeeder::class,
            TransactionRecordSeeder::class,
        ]);
    }
}
