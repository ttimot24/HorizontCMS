<?php 

	class Template{
		public $assigned_values = array();
		public $template;

		public function __construct(){


		}


		public function set_template($templ){

			$this->assign('THEME_PATH','themes/'.$templ."/");
			$this->template = "themes/" .$templ;
		}

		public function parse_template(){

			if(!empty($this->template)){
				if(file_exists($this->template)){

					$this->tpl = file_get_contents($this->template ."/index.php");

					$this->handle_inclusion();

				}


			}
			else{
				new Error();
				die("Can not parse the template!");
			}


		}


		public function assign($key,$value){

			if(!empty($key)){
				$this->assigned_values[strtoupper($key)] = $value;
			}

		}


		public function show(){

			if(count($this->assigned_values) > 0){
				foreach ($this->assigned_values as $key => $value) {
					$this->tpl = str_replace("{".$key."}",$value,$this->tpl);
				}
			}


			eval(' ?>'.$this->tpl.'<?php ');

			//echo $this->tpl;

		}


		private function handle_inclusion(){

			while(($result = $this->find_inclusion($this->tpl,"{#","#}"))!=""){

					$include = file_get_contents($this->template."/".$result);

					$this->tpl = str_replace("{#".$result."#}",$include,$this->tpl);

			}



		}


		private function find_inclusion($content,$start,$end){
		    $r = explode($start, $content);
		    if (isset($r[1])){
		        $r = explode($end, $r[1]);
		        return $r[0];
		    }
		    return '';
		}




	}


?>