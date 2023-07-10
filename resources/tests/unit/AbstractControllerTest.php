<?php


class AbstractControllerImplementation extends \App\Libs\Controller{

    public function getViewAttribute() {
        return $this->view;
    }

}


class AbstractControllerTest extends TestCase
{


    /** @before */
    public function mockRequest(){

        $this->requestMock = \Mockery::mock(\Illuminate\Http\Request::class)->makePartial();

        $this->viewMock = \Mockery::mock(\App\Libs\ViewResolver::class)->makePartial();
    }


    public function testControllerCreation()
    {
      

        $controller = new AbstractControllerImplementation($this->requestMock,$this->viewMock);
    
        $this->assertInstanceOf(\App\Libs\Controller::class,$controller);


    }

    public function testControllerRedirectMethods(){


        $location = "test/test";

        $controller = new AbstractControllerImplementation($this->requestMock,$this->viewMock);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class,$controller->redirect($location));
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class,$controller->redirectToSelf());
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class,$controller->insideLink($location));

        $this->assertEquals($this->baseUrl."/".$location,$controller->redirect($location)->getTargetUrl());
        $this->assertEquals($this->baseUrl."/".\Config::get("horizontcms.backend_prefix")."/".$location,$controller->insideLink($location)->getTargetUrl());

    }

    public function testIfVariablesSet(){

         $controller = new AbstractControllerImplementation($this->requestMock,$this->viewMock);

         $this->assertInstanceOf(\Illuminate\Http\Request::class,$controller->request);

         $this->assertInstanceOf(\App\Libs\ViewResolver::class,$controller->getViewAttribute());
    }


}



