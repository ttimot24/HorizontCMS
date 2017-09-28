<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{


    public function createTestUser(){
        
	        $this->user = factory(\App\Model\User::class)->create([
	             'username' => 'jeremy', 
	             'password' => bcrypt('testpass123')
	        ]);

    }



    public function testOpenLoginPage()
    {

	    if(\App\HorizontCMS::isInstalled()){	
	        $this->visit(\Config::get('horizontcms.backend_prefix'))
	             ->see('HorizontCMS')
                 ->see('Closer to the web');
                 
	    }

    }


    public function testInvalidCredentials(){

    	$this->createTestUser();

	    if(\App\HorizontCMS::isInstalled()){
	    	
	    	$this->visit(\Config::get('horizontcms.backend_prefix'))     
	    	     ->type($this->user->username,'username')
	             ->type('wrongpassword','password')
	             ->press('submit_login')
	             ->see('These credentials do not match our records.');
	    }


    }


}
