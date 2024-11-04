<?php

namespace App\Services;

use Laravolt\Avatar\Avatar;
use Illuminate\Support\Str;


class GenerateAvatar
{
    public function generate($name)
    {
        $filename = (string) Str::uuid() . '.png';
        $avatar = new Avatar(config('laravolt.avatar'));
        $avatar->setFontFamily(resource_path('fonts/NotoSansJP-Regular.ttf'))->create($name)->save(storage_path('app/public/avatars/' . $filename));
        return $filename;
    }
}
