<?php

namespace App\Services;

class UtilityService
{
    public function convertUrlToLink($string)
    {
        $regex = '/\b((http(s?):\/\/|www\.)[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*))/i';

        return preg_replace_callback($regex, function ($matches) {
            $url = $matches[0];
            $urlWithScheme = $matches[0];

            if (!preg_match("~^(?:f|ht)tps?://~i", $matches[0])) {
                $urlWithScheme = "http://" . $matches[0];
            }

            if (filter_var($urlWithScheme, FILTER_VALIDATE_URL)) {
                return '<a class="link" href="' . $urlWithScheme . '" target="_blank">' . $url . '</a>';
            }

            return $url;
        }, $string);
    }
}
