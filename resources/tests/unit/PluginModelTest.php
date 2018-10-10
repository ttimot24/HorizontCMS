<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PluginModelTest extends TestCase
{

    private $dummyName = "TestPlugin";

    /** @before */
    public function instantiatePlugin(){
         $this->plugin = new \App\Model\Plugin($this->dummyName);
    }


    public function testPluginInitiation(){

        $this->assertInstanceOf(\App\Model\Plugin::class,$this->plugin);

    }


    public function testInfoUsage(){

        $info = new \stdClass();
        $info->name = $this->dummyName;
        $info->version = "1.0";

        $requires = new \stdClass();
        $requires->core = "1.0.0-alpha.6";

        $info->requires = $requires;


        $this->assertFalse($this->plugin->hasInfo());

        $this->plugin->setAllInfo($info);

        $this->assertTrue($this->plugin->hasInfo());

        $this->assertEquals($this->plugin->getInfo("name"),$this->dummyName);

        $this->assertEquals($this->plugin->getInfo("version"),$info->version);

        $this->assertEquals($this->plugin->getInfo("requires"),$requires);

    }

    public function testRootDirSetter(){

        $this->plugin->setRootDir($this->dummyName);
        $this->assertEquals($this->plugin->root_dir,$this->dummyName);
    }


    public function testAllGetter(){

        $this->assertEquals($this->plugin->getName(), $this->dummyName);
        $this->assertEquals($this->plugin->getNamespaceFor("controller"),"\Plugin\\".$this->dummyName."\\App\\Controller\\");
        $this->assertEquals($this->plugin->getSlug(),namespace_to_slug($this->dummyName));
        $this->assertEquals($this->plugin->getPath(),"plugins".DIRECTORY_SEPARATOR.$this->dummyName.DIRECTORY_SEPARATOR);
        //$this->plugin->getDatabaseFilesPath();
        //$this->plugin->getIcon();
        $this->assertEquals($this->plugin->getShortCode(), "{[".$this->dummyName."]}");
        $this->assertEquals($this->plugin->getRegisterClass(),"\Plugin\\".$this->dummyName."\Register");
       // $this->plugin->getRequirements();
       // $this->assertEquals($this->plugin->getRequiredCoreVersion(),"1.0.0-alpha.6");

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

       // $this->assertInternalType("bool",$this->plugin->isCompatibleWithCore());

    }

}
