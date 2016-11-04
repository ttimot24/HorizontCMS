<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    protected $table = 'system_upgrade';

    public static function getCore()
    {
        return self::first();
    }

    public static function getCurrentVersion()
    {
        return self::orderBy('id', 'desc')->first();
    }

    public static function getAllAvailable()
    {
        $available_versions = json_decode(file_get_contents('http://www.eterfesztival.hu/hcms_online_store/hcms-versions.php'));

        $available_list = [];

        if (isset($available_versions)) {
            foreach (array_reverse($available_versions) as $available) {
                if ($available > self::getCurrentVersion()->version) {
                    $available_list[] = $available;
                }
            }
        }

        return $available_list;
    }

    public static function getUpgrades()
    {
        return self::all();
    }

    public static function getLatestVersion()
    {
        $available_list = self::getAllAvailable();

        return isset($available_list[0]) ? $available_list[0] : 0;
    }
}
