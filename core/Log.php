<?php

namespace Core;

class Log
{
    protected static function log(string $filename, string $message = '')
    {
        self::setupFolder();

        $file = fopen("../logs/{$filename}", 'a');

        date_default_timezone_set('UTC');
        $datetime = new \DateTime();

        $message = "[{$datetime->format('Y-m-d H:i:s')}] " . strip_tags($message) . "\n";

        fwrite($file, $message);

        fclose($file);
    }

    public static function error(string $message)
    {
        self::log('errors.log', $message);
    }

    protected static function setupFolder()
    {
        if (!file_exists('../logs')) {
            mkdir('../logs');
        }
    }
}
