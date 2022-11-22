<?php

namespace App\Model;

use \App\Libs\Model;
use \VisualAppeal\AutoUpdate;

class SystemUpgrade extends Model{

	public static $auto_upgrade;


	public static function checkUpgrade(){
	        $workspace = storage_path("framework/upgrade");
	        $url = \Config::get('horizontcms.sattelite_url')."/updates";

	        $update = new AutoUpdate($workspace.DIRECTORY_SEPARATOR.'temp', public_path() , 60);
			$currentVersion = self::getCurrentVersion();
            $update->setCurrentVersion( isset($currentVersion)? $currentVersion->version: \Config::get('horizontcms.version'));
            $update->setUpdateUrl($url);

            $update->addLogHandler(new \Monolog\Handler\StreamHandler($workspace . '/update.log'));
            $update->setCache(new \Desarrolla2\Cache\File($workspace . '/cache'), 3600);
            
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
