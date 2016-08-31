<?php

class DashboardController extends Controller{



	public function index(){

		$this->load_model('Blogpost');
		$this->load_model('User');

		$this->view->title = $this->view->language['dashboard'];
		$this->view->render("dashboard/index",[
													'domain' => $_SERVER['SERVER_NAME'],
													'server_ip' => $_SERVER['SERVER_ADDR'],
													'client_ip' => System::get_client_ip(),
													'blogposts'  => $this->blogpost->countAll(),
													'users' => $this->user->countAll(),
													'visits' => $this->system->visits(),
													'admin_logo' => $this->system->get_admin_logo(),
													'disk_space' => @(disk_free_space("/")/disk_total_space("/"))*100,
													'latest_version' => 7.5,
													'current_version' => 7.8,
											//		'latest_version' => SystemUpdate::get_upgrade_info('latest_version'),
											//		'current_version' => SystemUpdate::get_upgrade_info('current_version')->version,

												],
												TRUE);

	}




}





?>