<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewResolverTest extends TestCase
{

	public function inArrayRecurse($needle,$haystack){
		foreach($haystack as $value)
		{
		    if(in_array($needle, $value, true))
		    {
		        return true;
		    }
		}

		return false;
	}

    /** @before */
    public function instantiateViewResolver(){

        $this->viewResolver = new \App\Libs\ViewResolver();

    }


    public function testDataArraysSet(){

    	$this->assertEquals(\Config::get('horizontcms.css'), $this->viewResolver->data['css']);
    	$this->assertEquals(\Config::get('horizontcms.js'), $this->viewResolver->data['js']);

    }


    public function testSetters(){


    	$titleText = "test-title";
    	$addCss = "test.css";
    	$addJs = "test.js";
    	$addMetaName = "test-meta-name";
    	$addMetaData = "test-meta-data";

		$this->viewResolver->title($titleText);    	

		$this->assertEquals($titleText,$this->viewResolver->data["title"]);

		$this->viewResolver->css($addCss);
		$this->assertTrue(in_array($addCss, $this->viewResolver->data["css"]));

		$this->viewResolver->js($addJs);
		$this->assertTrue(in_array($addJs, $this->viewResolver->data["js"]));

		$this->viewResolver->meta($addMetaName,$addMetaData);


		$this->assertTrue($this->inArrayRecurse($addMetaName, $this->viewResolver->data["meta"]));
		$this->assertTrue($this->inArrayRecurse($addMetaData, $this->viewResolver->data["meta"]));

    }


    public function testRender(){

		$this->assertTrue($this->viewResolver->render("dashboard.index",["testkey1" => "test1","testkey2" => "test2"])->offsetExists('testkey1'));

		$this->assertEquals('test1',$this->viewResolver->render("dashboard.index",["testkey1" => "test1","testkey2" => "test2"])->offsetGet('testkey1'));

    }

}