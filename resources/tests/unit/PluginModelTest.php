<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PluginModelTest extends TestCase
{

    private $dummyName = "TestPlugin";

    private function getDummyInfo(){
        $info = new \stdClass();
        $info->name = $this->dummyName;
        $info->version = "1.0";

        $requires = new \stdClass();
        $requires->core = "1.0.0-alpha";

        $info->requires = $requires;

        return $info;
    }


    /** @before */
    public function instantiatePlugin(){
         $this->plugin = new \App\Model\Plugin($this->dummyName);
    }


    public function testPluginInitiation(){

        $this->assertInstanceOf(\App\Model\Plugin::class,$this->plugin);

    }


    public function testInfoUsage(){


        $this->assertFalse($this->plugin->hasInfo());

        $this->plugin->setAllInfo($this->getDummyInfo());

        $this->assertTrue($this->plugin->hasInfo());

        $this->assertEquals($this->plugin->getInfo("name"),$this->dummyName);

        $this->assertEquals($this->plugin->getInfo("version"),$this->getDummyInfo()->version);

        $this->assertEquals($this->plugin->getInfo("requires"),$this->getDummyInfo()->requires);

    }

    public function testRootDirSetter(){

        $this->plugin->setRootDir($this->dummyName);
        $this->assertEquals($this->plugin->root_dir,$this->dummyName);
    }


    public function testAllGetter(){


        $this->plugin->setAllInfo($this->getDummyInfo());

        $this->assertEquals($this->plugin->getName(), $this->dummyName);
        $this->assertEquals($this->plugin->getNamespaceFor("controller"),"\Plugin\\".$this->dummyName."\\App\\Controller\\");
        $this->assertEquals($this->plugin->getSlug(),namespace_to_slug($this->dummyName));
        $this->assertEquals($this->plugin->getPath(),"plugins".DIRECTORY_SEPARATOR.$this->dummyName.DIRECTORY_SEPARATOR);
        //$this->plugin->getDatabaseFilesPath();
        //$this->plugin->getIcon();
        $this->assertEquals($this->plugin->getShortCode(), "{[".$this->dummyName."]}");
        $this->assertEquals($this->plugin->getRegisterClass(),"\Plugin\\".$this->dummyName."\Register");

        $this->assertEquals($this->plugin->getRequirements(),$this->getDummyInfo()->requires);
        $this->assertEquals($this->plugin->getRequiredCoreVersion(),$this->getDummyInfo()->requires->core);

    }

    public function testMethodsDependingOnRegister(){

    	$returnRouteOptions = [
				'middleware' => ['web'],
				'namespace' => "\Plugin\\".$this->dummyName."\\App\\",
				'prefix' => $this->plugin->getSlug(),
		];

    	$externalMock = \Mockery::mock("overload:\Plugin\\".$this->dummyName."\\Register");
        $externalMock->shouldReceive('routeOptions')
            ->andReturn($returnRouteOptions);


        $default = ['test'];
        $this->assertNull($this->plugin->getRegister("dummy"));
        $this->assertEquals($this->plugin->getRegister("dummy",$default),$default);
       // $this->assertInternalType('array',$this->plugin->getRegister("routeOptions"));
       // $this->assertEquals($this->plugin->getRegister("routeOptions"),$returnRouteOptions);

    }

    public function testIsAndHas(){

      //  \Config::set('horizontcms.version',$this->getDummyInfo()->requires->core);

      //  $this->assertTrue($this->plugin->isCompatibleWithCore());

      //  \Config::set('horizontcms.version','1.0.0-alpha.2');

                //        dd($this->plugin->isCompatibleWithCore());

       // $this->assertFalse($this->plugin->isCompatibleWithCore());

    }

}
