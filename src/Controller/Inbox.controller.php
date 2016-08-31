<?php 


class InboxController extends Controller{



	public function index(){

		if(!@fsockopen("localhost", 25, $errno, $errstr, 5)){
			throw new Error(9,"No SMTP mail server found on port: <b>25</b>!");
		}
		else{
			//$mbox = imap_open ("{localhost:110/pop3}INBOX", "eterfesz", "Fesztival123");
			$mbox = imap_open("{localhost:143}INBOX", "eterfesz", "Fesztival123");
		//	$mbox = imap_open ("{localhost:993/imap/ssl}INBOX", "eterfesz", "Fesztival123");

			var_dump(imap_last_error());
		}


	}






}






?>