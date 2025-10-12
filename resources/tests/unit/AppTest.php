<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

class AppTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A test for app creation
     *
     * @return void
     */
    public function testAppCreation()
    {
        $this->assertInstanceOf(\App\HorizontCMS::class, $this->app);
    }


    public function testAppRootDir()
    {

        $this->assertEquals($this->app->publicPath(), getcwd() . DIRECTORY_SEPARATOR);
    }


    public function testIsInstalled()
    {

        if (file_exists(base_path(".env")) || !empty(env("INSTALLED", ""))) {

            $this->assertTrue($this->app->isInstalled());
            $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $this->app->plugins);
        } else {

            $this->assertFalse($this->app->isInstalled());
            $this->assertNotNull($this->app->plugins);
            $this->assertEquals(true, $this->app->plugins->isEmpty());
        }
    }

    public function testSetAndHoldPlugins()
    {

        $this->app->setPlugins(collect([new \App\Model\Plugin("test")]));
        $this->assertEquals(1, $this->app->getPlugins()->count());
        $this->assertEquals("test", $this->app->plugins->first()->root_dir);
    }

}
