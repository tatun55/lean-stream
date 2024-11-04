<?php

namespace App\Console\Commands\Debug;

use Illuminate\Console\Command;
use App\Models\Message;

class GetSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-sender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dump('app:get-sender');
        $msg = Message::first();
        dump($msg);
        dump($msg->sender);
    }
}
