<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Organisation;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orgId = Organisation::first()->id;
        $clients = Client::where('organisation_id', $orgId)->get();
        $messages = [];
        foreach ($clients as $client) {
            $days = 50;
            for ($i = 1; $i <= $days; $i++) {
                $messages[] = [
                    'from_user' => true,
                    'sender_id' => $client->line_user_id,
                    'receiver_id' => null,
                    'organisation_id' => $orgId,
                    'body' => ($client->display_name) . 'からのテストメッセージです。',
                    'created_at' => now()->subDay($days - $i)->format('Y-m-d H:i:s'),
                ];
            }
        }
        Message::insert($messages);
    }
}
