<?php 



class SystemUpdate{



	public static function get_upgrade_info($what){
		$sys_upgrades = array_reverse(array_slice(scandir("core/upgrades/"),2));
		$available_versions = json_decode(file_get_contents("http://horizontcms.16mb.com//hcms-versions.php"));
		$all_upgrades = count($sys_upgrades);

		switch($what){
			case 'current_version': $info = !file_exists("core/upgrades/".$sys_upgrades[0])? FALSE : simplexml_load_file("core/upgrades/".$sys_upgrades[0]);
									return $info;
									break;

			case 'installed_version': $info = !file_exists("core/upgrades/".$sys_upgrades[$all_upgrades-1])? FALSE : simplexml_load_file("core/upgrades/".$sys_upgrades[$all_upgrades-1]);
									  return $info;
								 	  break;

			case 'upgrade_list': 	
									unset($sys_upgrades[$all_upgrades-1]);
									$upgrade_list = array_slice($sys_upgrades,1);


									if(count($upgrade_list)>0){
										foreach($upgrade_list as $upgrade){
											$info[] = !file_exists("core/upgrades/".$upgrade)? FALSE : simplexml_load_file("core/upgrades/".$upgrade);
										}
										return $info;
									}else{
										return NULL;
									}

									
									break;

			case 'latest_version': return @array_pop($available_versions);
								    break;

			case 'available_list':  $available_list = array();

									foreach(array_reverse($available_versions) as $available){
										if($available > self::get_upgrade_info('current_version')->version){
											$available_list[] = $available;
										}
									}

									return $available_list;
									break;

		}

	}









}