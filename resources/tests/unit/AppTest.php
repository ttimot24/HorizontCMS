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


        $this->assertInstanceOf(\App\HorizontCMS::class, $this->app);


    }


    public function testAppRootDir(){

        $this->assertEquals($this->app->publicPath(),getcwd().DIRECTORY_SEPARATOR);

    }


    public function testIsInstalled(){

        if(file_exists(base_path(".env")) || env("INSTALLED","")!=""){

            $this->assertTrue($this->app->isInstalled());
            $this->assertNotNull('array',$this->app->plugins);

        }else{

            $this->assertFalse($this->app->isInstalled());
            $this->assertNull($this->app->plugins);

        }

    }

}
