<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $secondOrg = Organisation::where('type', 'manshion_union')->first()->id;
        User::factory()->create([
            'organisation_id' => $secondOrg,
            'name' => 'テスト＿管理組合',
            'role' => 'manager',
            'email' => 'test.staff1@example.com',
            'password' => bcrypt('63d17bc7d6bae48f'),
            'message' => '',
        ]);
    }
}
