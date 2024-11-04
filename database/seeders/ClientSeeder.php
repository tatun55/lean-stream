<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orgId = Organisation::first()->id;

        $clients = [];
        for ($i = 1; $i <= 15; $i++) {

            // $table->string('id',33)->primary();
            // $table->string('line_display_name',32);
            // $table->string('line_picture_url')->nullable();
            // $table->string('belong_to',32)->nullable();
            // $table->string('sei',16)->nullable();
            // $table->string('mei',16)->nullable();
            // $table->string('phone',11)->nullable();
            // $table->string('address')->nullable();
            // $table->string('remark')->nullable();
            // $table->timestamps();

            $clients[] = [
                'organisation_id' => $orgId,
                'line_user_id' => 'U' . Str::random(31),
                'line_display_name' => 'テスト_クライアント' . (string) $i,
                'line_picture_url' => 'img/default-avatar.png',
            ];
        }
        Client::insert($clients);
    }
}
