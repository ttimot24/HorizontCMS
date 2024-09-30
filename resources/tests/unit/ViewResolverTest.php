<?php

/**
 * @deprecated deprecated since version 1.0.0
 */
class ViewResolverTest extends TestCase
{
	private $viewResolver;

	public function inArrayRecurse($needle, $haystack)
	{
		foreach ($haystack as $value) {
			if (in_array($needle, $value, true)) {
				return true;
			}
		}

		return false;
	}


	protected function setUp(): void
	{
		parent::setUp();
		$this->viewResolver = new \App\Libs\ViewResolver();
	}


	public function testDataArraysSet()
	{

		$this->assertEquals(\Config::get('horizontcms.css'), $this->viewResolver->data['css']);
		$this->assertEquals(\Config::get('horizontcms.js'), $this->viewResolver->data['js']);
	}


	public function testSetters()
	{


		$titleText = "test-title";
		$addCss = "test.css";
		$addJs = "test.js";

		$this->viewResolver->title($titleText);

		$this->assertEquals($titleText, $this->viewResolver->data["title"]);

		$this->viewResolver->css($addCss);
		$this->assertTrue(in_array($addCss, $this->viewResolver->data["css"]));

		$this->viewResolver->js($addJs);
		$this->assertTrue(in_array($addJs, $this->viewResolver->data["js"]));
	}


	public function testRender()
	{

		$this->assertTrue($this->viewResolver->render("dashboard.index", ["testkey1" => "test1", "testkey2" => "test2"])->offsetExists('testkey1'));

		$this->assertEquals('test1', $this->viewResolver->render("dashboard.index", ["testkey1" => "test1", "testkey2" => "test2"])->offsetGet('testkey1'));
	}
}
