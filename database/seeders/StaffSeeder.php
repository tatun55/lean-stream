<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orgId = Organisation::where('type', 'company')->first()->id;

        User::factory()->create([
            'organisation_id' => $orgId,
            'name' => 'テスト＿マスター管理者',
            'role' => 'admin',
            'email' => 'test1@example.com',
            'message' => '',
        ]);

        User::factory()->create([
            'organisation_id' => $orgId,
            'name' => 'テスト＿管理職員',
            'role' => 'manager',
            'email' => 'test2@example.com',
            'message' => '',
        ]);

        User::factory()->create([
            'organisation_id' => $orgId,
            'name' => 'テスト＿社員',
            'role' => 'staff',
            'email' => 'test3@example.com',
            'message' => '',
        ]);

        User::factory()->create([
            'organisation_id' => $orgId,
            'name' => 'テスト＿外部スタッフ',
            'role' => 'external',
            'email' => 'test4@example.com',
            'message' => '',
        ]);

        $secondOrg = Organisation::where('type', 'manshion_union')->first()->id;
        User::factory()->create([
            'organisation_id' => $secondOrg,
            'name' => 'テスト＿管理組合',
            'role' => 'manager',
            'email' => 'test5@example.com',
            'message' => '',
        ]);

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
