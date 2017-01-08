<?php

namespace App\Model;

use \App\Libs\Model;
use \VisualAppeal\AutoUpdate;

class SystemUpgrade extends Model{

	public static $auto_upgrade;


	public static function checkUpgrade(){
	        $workspace = storage_path().DIRECTORY_SEPARATOR."framework".DIRECTORY_SEPARATOR."upgrade";
	        $url = "http://www.eterfesztival.hu/hcms_online_store/updates";

	        $update = new AutoUpdate($workspace.DIRECTORY_SEPARATOR.'temp', getcwd() , 60);
            $update->setCurrentVersion(self::getCurrentVersion()->version);
            $update->setUpdateUrl($url);

            $update->addLogHandler(new \Monolog\Handler\StreamHandler($workspace . '/update.log'));
            $update->setCache(new \Desarrolla2\Cache\Adapter\File($workspace . '/cache'), 3600);
            
            $update->checkUpdate();

            self::$auto_upgrade = $update;

            return self::$auto_upgrade;
	}


	public static function getCore(){
		return self::first();
	}


	public static function getCurrentVersion(){
		return self::orderBy('id','desc')->first();
	}


	public static function getAllAvailable(){

		return array_map(function($version) {
                return (string) $version;
            }, self::$auto_upgrade->getVersionsToUpdate());

	}


	public static function getUpgrades(){
		return self::all()->reverse();
	}


	public static function getLatestVersion(){
		return self::$auto_upgrade->getLatestVersion();
	}



}
