<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AppTest extends TestCase
{
    /**
     * A test for app creation
     *
     * @return void
     */
    public function testAppCreation()
    {


        $this->assertNotNull($this->app);

        $this->assertEquals($this->app->publicPath(),getcwd().DIRECTORY_SEPARATOR);

        if(file_exists(base_path(".env")) || env("INSTALLED","")!=""){

            $this->assertTrue($this->app->isInstalled());
            $this->assertNotNull($this->app->plugins);

        }else{

            $this->assertFalse($this->app->isInstalled());
            $this->assertNull($this->app->plugins);

        }


    }
}
