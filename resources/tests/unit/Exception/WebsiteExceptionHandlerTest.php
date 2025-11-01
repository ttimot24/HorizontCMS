<?php

class WebsiteExceptionHandlerTest extends TestCase
{

    private $requestMock;
    private $exceptionHandler;

    /** @before */
    public function instantiateExceptionHandler()
    {

        $this->requestMock = \Mockery::mock(\Illuminate\Http\Request::class)->makePartial();
        $this->requestMock->headers = new \Symfony\Component\HttpFoundation\HeaderBag([]);
        $this->requestMock->settings = ['website_debug' => 1];

        $this->exceptionHandler = new \App\Exceptions\WebsiteExceptionHandler($this->createMock(\Illuminate\Contracts\Container\Container::class));
    }


    public function testWebsiteExceptionHandler(){
        

        $response = $this->exceptionHandler->render($this->requestMock, new \Exception('Any exception'));

        $this->assertInstanceOf(\Illuminate\Http\Response::class, $response);

        $this->requestMock->settings['website_debug'] = 1;

        $response = $this->exceptionHandler->render($this->requestMock, new \Exception('Any exception'));

        $this->assertInstanceOf(\Illuminate\Http\Response::class, $response);
    }

}
