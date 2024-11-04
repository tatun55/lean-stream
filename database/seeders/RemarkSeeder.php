<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Organisation;
use App\Models\Remark;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RemarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orgId = Organisation::first()->id;
        $admin = User::where('role', 'admin')->first();
        $clients = Client::where('organisation_id', $orgId)->get();
        $messages = [];
        foreach ($clients as $client) {
            $days = 50;
            for ($i = 1; $i <= $days; $i++) {
                $messages[] = [
                    'from_user' => false,
                    'sender_id' => $admin->id,
                    'receiver_id' => null,
                    'organisation_id' => $orgId,
                    'body' => ($client->display_name) . 'の内部メモです。',
                    'created_at' => now()->subDay($days - $i)->format('Y-m-d H:i:s'),
                ];
            }
        }
        Remark::insert($messages);
    }
}
