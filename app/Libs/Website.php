<?php 


class Website{

	public static $_BLOGPOST;
	public static $_USER;
	public static $_CURRENT_USER;
	public static $_PAGE;
	public static $_REQUESTED_PAGE;
	public static $_SETTINGS;
	public static $_THEME_PATH;
	public static $_SLUGS;
	public static $_PLUGINS;
	public static $_HEADER_IMAGES;
	public static $_SOCIAL_MEDIA;
	
	public static $message;
	public static $system,$pages;
	

	public static function initalize(){

		$settings = new \App\Model\Settings();
		$settings->assignAll();

		self::$_SETTINGS = $settings->settings;

		self::$_THEME_PATH = 'themes/'.\App\Model\Settings::get('theme');

		self::$_CURRENT_USER = \Auth::user();

		/*$system = new System();

		$url = UrlManager::get_slugs();

		self::$_BLOGPOST = new Blogpost();
		self::$_USER = new User();
		self::$_PAGE = new Page();
		self::$_PLUGINS = new Plugin();
		self::$_REQUESTED_PAGE = self::$_PAGE->get_instance_by_name($url[0]);

		self::$_SLUGS = $url;
		self::$_HEADER_IMAGES = new HeaderImage();
		self::$_SOCIAL_MEDIA = new Socialmedia();

		Session::get('id')==NULL ? : self::$_CURRENT_USER = self::$_USER->get_instance(Session::get('id'));

		self::$message = new Message();
*/
	}



	public static function define_base(){

		return "<base href=".BASE_DIR ." />";
	}




	public static function handle_routing(){

		    if(isset(Website::$_REQUESTED_PAGE->url) 
		    	&& Website::$_REQUESTED_PAGE->url!="" 
		    	&& file_exists(Website::$_THEME_PATH ."/page_templates/".Website::$_REQUESTED_PAGE->url)){
		    	
                require_once(Website::$_THEME_PATH ."/page_templates/".Website::$_REQUESTED_PAGE->url);
            	          
            }
            else if(isset(Website::$_REQUESTED_PAGE)){
            	
            	if(file_exists(Website::$_THEME_PATH ."/page.php")){
                	require_once(Website::$_THEME_PATH ."/page.php");
            	}
            	else{
            		echo "<h1>".Website::$_REQUESTED_PAGE->name."</h1>";
            		echo "<p>".Plugin::triggerPagePlugin(Website::$_REQUESTED_PAGE->page)."</p>";
            	}

            }
            else{
               
                if(file_exists(Website::$_THEME_PATH ."/404.php")){
                    require_once(Website::$_THEME_PATH ."/404.php");
                }
                else{
                    echo "404 - Sorry page not found!";    
                }

            }
            
	}


	public static function logo(){
		return Storage::get('images/logo',Website::$_SETTINGS->logo);
	}


	public static function require_theme_file($file){
		require(Website::$_THEME_PATH."/".$file);
	}

	public static function require_theme_stylesheet($file){
		return Website::$_THEME_PATH."/".$file;
	}


}
