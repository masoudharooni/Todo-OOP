<?php

namespace Utility;

class Cache
{
    private static $cacheStatus = 1; # enable or unable cache status
    private static $cacheExpireTime = 3600;
    private static $cacheFile;
    public static function init()
    {
        self::$cacheFile = CACHE_DIR . "/" . md5($_SERVER['REQUEST_URI']) . ".json";
        if ($_SERVER['REQUEST_METHOD'] != "GET")
            self::$cacheStatus = 0;
    }
    public static function isExistCache(): bool
    {
        self::init();
        return (file_exists(self::$cacheFile) && (time() - self::$cacheExpireTime) < filemtime(self::$cacheFile));
    }
    public static function start()
    {
        if (!self::$cacheStatus)
            return;
        if (self::isExistCache()) {
            readfile(self::$cacheFile);
            exit;
        }
        ob_start();
    }
    public static function end()
    {
        if (!self::$cacheStatus)
            return;
        file_put_contents(self::$cacheFile, ob_get_contents());
        ob_end_flush();
    }
}
