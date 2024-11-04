<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organisation::create([
            'type' => 'company',
            'name' => '株式会社レクシード',
            'avatar' => asset('rexceed-logo.png'),
            'address' => '東京都港区',
            'tel' => '03-1234-5678',
            'url' => 'https://rexceed-kt.co.jp/',
            'note' => 'テスト用の組織データです。',
        ]);
        Organisation::create([
            'type' => 'manshion_union',
            'name' => 'Aマンション管理組合',
            'avatar' => 'https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/FV.jpg',
            'address' => '東京都港区',
            'tel' => '03-1234-5678',
            'url' => 'https://a-manshion-union/',
            'note' => 'テスト用の管理組合データです。',
        ]);
    }
}
