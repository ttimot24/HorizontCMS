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
	

	public static function initalize($wengine){
		

		self::$_SLUGS = \Request::segments();

		self::$_SETTINGS = json_decode(json_encode($wengine->request->settings));

		self::$_THEME_PATH = $wengine->getTheme()->getPath();

		self::$_CURRENT_USER = \Auth::user();

		self::$_REQUESTED_PAGE = \Request::segment(1)===null ? \App\Model\Page::find($wengine->request->settings['home_page']) : \App\Model\Page::findBySlug($wengine->request->segment(1));

		self::$_HEADER_IMAGES =  collect(\App\Model\HeaderImage::all());

		self::$message = new BootstrapMessage();


	}



	public static function define_base(){

		echo "<base href=".\Config::get('app.url') ." />";
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
            		echo "<p>".\App\Libs\Shortcode::compile(Website::$_REQUESTED_PAGE->page)."</p>";
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
		return 'storage/images/logos/'.Website::$_SETTINGS->logo;
	}


	public static function require_theme_file($file){
		require(Website::$_THEME_PATH."/".$file);
	}

	public static function require_theme_stylesheet($file){
		return Website::$_THEME_PATH."/".$file;
	}


}
