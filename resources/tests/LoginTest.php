<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testCheckLoginPage()
    {

	    if(\App\HorizontCMS::isInstalled()){	
	        $this->visit(\Config::get('horizontcms.backend_prefix'))
	             ->see('HorizontCMS')
                 ->see('Closer to the web');

	    }

    }

}
