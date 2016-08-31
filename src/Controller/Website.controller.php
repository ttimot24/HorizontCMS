<?php 

class WebsiteController extends Controller{

	//private $robotUserAgents = ['bingbot','AhrefsBot','Googlebot','MJ12bot','msnbot','YandexBot','YandexImages','TurnitinBot','BLEXBot','spbot','Pingdom','SISTRIX','AdsBot-Google','Exabot','UptimeRobot','LoadTimeBot','linkdexbot','psbot-page','trendictionbot','woopingbot','200PleaseBot','pmoz.info','archive.org_bot','MojeekBot','Mail.RU_Bot','socialbm_bot','ClickTale','niki-bot','urlcheck-robot','PagesInventory','FreeWebMonitoring','yacybot','Wotbox','Twitterbot','CrawlDaddy','psbot','bitlybot','woobot','rogerbot','AdMedia bot','Slurp','Grando-feed'];


	public function __construct(){

		$this->message = new Message();
		$this->system = new System();
		$this->load_model('Visits');
		$this->theme = new Theme();
		$this->template_engine = new Template();

		$this->slugs = UrlManager::get_slugs();


		Website::initalize();

	}



	public function index($args=NULL){

		error_reporting(((int)$this->system->settings->website_debug) * (-1));
		ini_set('display_errors', (int)$this->system->settings->website_debug);


		if($this->system->settings->website_down == 1){
			$this->websiteDownAction();
		}


		if($this->slugs==NULL){

			Website::$_REQUESTED_PAGE = Website::$_PAGE->get_welcome_page();

			$POST_ARRAY['hostname'] = isset($_SERVER["REMOTE_HOST"]) ? $_SERVER["REMOTE_HOST"] : gethostbyaddr($_SERVER["REMOTE_ADDR"]);

			$this->visits->construct_by_array($POST_ARRAY);
			$this->visits->setValue('date',time());
			$this->visits->setValue('ip',System::get_client_ip());

			/*if(!$this->isRobot()){
				$status = $this->visits->save();
			}*/

		}else if(Website::$_PAGE->get_instance_by_name($this->slugs[0])==NULL){
			$this->pageNotFoundAction();
		}



		$this->template_engine->render($this->theme->get_active_theme()->dir_name);

	}


	public function websiteDownAction(){
		
		if(file_exists($this->theme->get_active_theme()->dir_name."/website_down.php")){
			require_once($this->theme->get_active_theme()->dir_name."/website_down.php");
		}else{
			require_once(RESOURCE_DIR."/static_pages/website_down.php");
		}

		exit;
	}


	public function pageNotFoundAction(){


			
			if(file_exists(THEME_DIR.$this->theme->get_active_theme()->dir_name."/404.php")){
				require_once(THEME_DIR.$this->theme->get_active_theme()->dir_name."/404.php");
			}else{
				echo "<center><h1>404 - Page not found!</h1></center>";
			}

			exit;
	}



	public function logInAction(){
		

		if(Post::get('username')!=NULL && Post::get('password')!=NULL){
			    $username = Post::get('username');
			    $password = Post::get('password');

			    $user = Website::$_USER->get_instance_by_username($username);


				    if($user!=FALSE && $user->authenticate($password)){
				    	if($user->active==1){
					      Session::set('id',$user->id);
					      Session::set('username',$user->username);
					      Session::set('permission',$user->rank);	
					      $user->increment_visits();
					    }else{
					    	Session::set('status','inactive');
					    }

				    }else{

				      Session::set('status','fail');

				    }
		}

		$this->redirect_to_self();

	}



	/*public function isRobot(){
	 foreach ($this->robotUserAgents as $agentShortName) {
	     if (stripos($this->visits->hostname, $agentShortName) !== false) {
	         return true;
	         }
	     }
	     return false;
	}
*/

	





}





?>