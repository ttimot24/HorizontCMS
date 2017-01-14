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
    public function testBasicExample()
    {

	    if(\App\HorizontCMS::isInstalled()){	
	        $this->visit('/admin')
	             ->see('HorizontCMS');

	        $this->visit('/admin')
	             ->see('Closer to the web');
	    }

    }
}
