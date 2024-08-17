<?php

class Security{

    public static function vulnerableExtensions(){
        return '/^.*\.('.implode('|',["php","php5","php7","phar","phtml","htaccess"]).')$/i';
    }

    public static function isExecutable($file){
        return preg_match(self::vulnerableExtensions(), strtolower($file));
    }


}