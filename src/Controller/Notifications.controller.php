<?php 


class NotificationsController extends Controller{


	public function index(){

		$this->load_model('Notification','model');



		$this->model->mergeEvents([
									'blogpost' => ['book','title','date'],
									'user' => ['user','username','reg_date'],
									'blogpostComment' => ['comment','comment','date'],

								  ]);
	

		$this->view->title = "Notifications";
		$this->view->render('notification/index',['notifications' => $this->model->getEvents()]);
	}




}