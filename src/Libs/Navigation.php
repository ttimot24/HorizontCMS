<?php 

class Navigation{

	public $menu_items = array();


	public function __construct(array $navs,$language){

    /*$alerts = new Notification();


    $alerts->mergeEvents([
                  'blogpost' => ['book','title','date'],
                  'user' => ['user','username','reg_date'],
                  'blogpostComment' => ['comment','comment','date'],

                  ]);
    $this->alerts = $alerts->getEvents(5);
*/

		$this->menu_items = $navs;



	}



	public function add_main_menu($name,$link='#',$permission=NULL){
		$this->menu_items[] = ["name" => $name,"link" => "admin/".$link,"permission" => $permission];
	}


	public function add_submenu($parent,$name,$link='#',$permission=NULL){
		/*$key = array_search($parent, array_column($this->menu_items, LAN_MENU_2));
		var_dump($key);*/
		$this->menu_items[$parent]["childs"][] = ["name" => $name,"link" => "admin/".$link,"permission" => $permission];
	}


  public function mergeCustomMenuItems(array $custom_items){
    foreach($custom_items as $each_item){
      array_push($this->menu_items,$each_item);
    }
  }





}