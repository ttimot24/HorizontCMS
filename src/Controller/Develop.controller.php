<?php


class DevelopController extends Controller{


	public function index(){

		$this->load_model('Theme');

		$this->view->title = "Develop";
		$this->view->render("develop/develop",[
												'dirs' => $this->theme->get_all(),
												]);
	}


	public function newtheme(){

		$project_dir = str_replace(" ","_",strtolower($this->request->getPost('pj_name')));

		$status = mkdir("themes/".$project_dir);
		mkdir("themes/".$project_dir."/page_templates");


		$header = fopen("themes/".$project_dir."/header.php", "w+") or die("Unable to open file!");
	    $index = fopen("themes/".$project_dir."/index.php", "w+") or die("Unable to open file!");
	    $footer = fopen("themes/".$project_dir."/footer.php", "w+") or die("Unable to open file!");
	    $theme_info = fopen("themes/".$project_dir."/theme_info.xml", "w+") or die("Unable to open file!");

	    $txt = "<html>\n\t<head>\n\n\t</head>\n\t<body>";

	    fwrite($header,$txt);


	    $txt = "\n<h1>Hello world!</h1>\n";

	    fwrite($index, $txt);

	    $txt = "</body></html>";

	    fwrite($footer,$txt);

	    $txt = "<?xml version='1.0' ?>\n\n<theme_info>\n 
	    									<name>".$this->request->getPost('pj_name')."</name>\n 
	    									<version>1.0</version>\n 
	    									<description>".$this->request->getPost('theme_description')."</description>\n 
	    									<author>".$this->request->getPost('author_name')."</author>\n 
	    								</theme_info>";

	    fwrite($theme_info, $txt);


	    fclose($header);
	    fclose($index);
	    fclose($footer);
	    fclose($theme_info);


				if($status){
					$this->view->message->setMessage('success','Successfully  created a new theme!');
				}
				else{
					$this->view->message->setMessage('error','Something went wrong');
				}


	    $this->redirect("admin/develop/index");


	}


	public function opentheme($args){

		$open = isset($args[1])? $args[1] : "index.php"; 

		$file = fopen("themes/" .$args[0] ."/" .$open, "r");

		$tmp_file = @fread($file,filesize("themes/".$args[0]."/".$open));

		fclose($file);


		$this->view->title = "Develop";
		$this->view->render("develop/open",[
											'current_theme' => $args[0],
											'files' => array_slice(scandir("themes/" .$args[0]),2),
											'opened_file_name' => $open,
											'opened_file' => $tmp_file,
											]);
	}



	public function createfile($args){

		if(!file_exists('themes/' .$args[0] ."/".$this->request->getPost('file_name') .".". $this->request->getPost('select_extension'))){
			$status = $file = fopen('themes/' .$args[0] ."/".$this->request->getPost('file_name') .".". $this->request->getPost('select_extension'), "w");

			if($status){
				$this->view->message->setMessage('success','Successfully  created a new file!');
			}
			else{
				$this->view->message->setMessage('error','Something went wrong');
			}


		}
		else{
			$this->view->message->setMessage('error',"File already exists!");
		}



		$this->redirect_to_self();
	}



	public function savefile($args){


		$status = file_put_contents('themes/' .$args[0] ."/".$args[1], $this->request->getPost('file_content'));

			if($status){
				$this->view->message->setMessage('success','File saved!');
			}
			else{
				$this->view->message->setMessage('error','Something went wrong');
			}



		$this->redirect_to_self();
	}





}




?>