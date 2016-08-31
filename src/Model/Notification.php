<?php 

class Notification{

	private $notifications;
	private $offset = 0;

	public function __construct(){

		//$this->addNotification('<b><i class="fa fa-desktop" aria-hidden="true" style="font-size:22px;padding-top:7.5px;"></i></b> Succesfully installed HorizontCMS');
	}

	public function mergeEvents(array $entites_name){

		foreach($entites_name as $entity_name => $value){
			$name = ucfirst($entity_name);
			$entity = new $name;

			$all = $entity->get_last(100);

			foreach($all as $ent){
				$this->notifications[] = [$value[0],$ent->{$value[1]},$ent->$value[2]];
			}

		}
	
		$this->notifications = $this->array_sort($this->notifications);
	}

	public function setOffset($offset){
		$this->offset = $offset;
	}

	public function addNotification($notification){
		$this->notifications[] = $notification;
	}

	public function getEvents($offset=null){

		if(isset($offset)){
			return array_reverse(array_slice($this->notifications, 0, $offset));
		}

		return array_reverse($this->notifications);
	}



	private function array_sort($array){



		if(count($array)==0){ return $array; }

		 

		for($i=0;$i<count($array)-1;$i++){
		for($j=0;$j<count($array)-1;$j++){

			if($array[$j][2]<$array[$j+1][2]){
				$tmp = $array[$j];
				$array[$j] = $array[$j+1];
				$array[$j+1] = $tmp;
			}

		}
		}

		return array_reverse($array);
	}


}