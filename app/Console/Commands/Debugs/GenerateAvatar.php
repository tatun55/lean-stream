<?php

namespace App\Console\Commands\Debugs;

use Illuminate\Console\Command;
use Laravolt\Avatar\Avatar;
use Illuminate\Support\Str;



class GenerateAvatar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-avatar';

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
        echo 'Generating avatar...';
        $avatar = new Avatar(config('laravolt.avatar'));
        $avatar->setFontFamily(resource_path('fonts/NotoSansJP-Regular.ttf'))->create("高井")->save(storage_path('app/public' . (string) Str::uuid() . '.png'));
    }
}
