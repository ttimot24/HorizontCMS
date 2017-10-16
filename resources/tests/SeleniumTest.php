<?php

class SeleniumTest extends PHPUnit_Extensions_Selenium2TestCase{

   /* protected $captureScreenshotOnFailure = TRUE;
    protected $screenshotPath = '/var/www/localhost/htdocs/screenshots';
    protected $screenshotUrl = 'http://localhost/screenshots';*/
    protected $browser = 'firefox';


    protected function setUp()
    {

    	$this->setBrowser($this->browser);
        $this->setBrowserUrl('http://localhost/');
   

    	$app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }


}