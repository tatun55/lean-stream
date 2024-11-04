<?php

namespace Database\Seeders;

use App\Models\LineBot;
use App\Models\Organisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LineBotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organisationId = Organisation::where('name', '株式会社レクシード')->first()->id;
        LineBot::create([
            'organisation_id' => $organisationId,
            'destination' => 'U067a57229c3eb075732fa12d5c3dfeaf',
            'basic_id' => '@532patvm',
            'channel_secret' => '9b2ba28a25a9117029a4f7ee5ceb7cdd',
            'access_token' => 'zCEmzhYOCregcQ2Z117+GzKykOHe581TB6I5uudYh6RwPyEIxbb85OExv8p38PTqgLLpr60Gb9Lu99sHxYwg4b6rm3GnEx0xchNiB6OGvQB7d3uzYiZyjYESivHOnFpcqllQUS7Bn+NXRfzPKExotwdB04t89/1O/w1cDnyilFU=',
        ]);

        $organisationId = Organisation::where('name', 'Aマンション管理組合')->first()->id;
        LineBot::create([
            'organisation_id' => $organisationId,
            'destination' => 'U43ac6cf65b78d8747668e9d7d1dad1a7',
            'basic_id' => '@610eeljr',
            'channel_secret' => '656a942e4330dd2a45600d5792a320f8',
            'access_token' => 'n19tvqk/MAQs9/CXS60VCmTZV5eNnkFq7d4IC2LOikR+6m3vl5xNV8IvI30RWr8+y8DsAE4PweKCSeZZzVhsdJiRNhVa2gekQxTnm+eNZAuDaW9njAS27CzdUjqSjzuPrG5wIrEnDYdSQEw1Uxyi3wdB04t89/1O/w1cDnyilFU=',
        ]);
    }
}
