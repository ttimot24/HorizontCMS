<?php

require_once("../../resources/tests/SeleniumTest.php");

class LoginBrowserTest extends SeleniumTest{



    public function testTitle()
    {

        $this->url('/'.\Config::get('horizontcms.backend_prefix'));
        $this->assertEquals('Welcome - HorizontCMS', $this->title());
    }






}