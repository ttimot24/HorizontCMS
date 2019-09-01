<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExceptionHandler extends TestCase
{

    /** @before */
    public function instantiateExceptionHandler(){

        $this->requestMock = \Mockery::mock(\Illuminate\Http\Request::class)->makePartial();

        $this->exceptionHandler = new \App\Exceptions\Handler($this->createMock(\Illuminate\Contracts\Container\Container::class));
    }

    public function testRenderAuthorizationException(){
        $response = $this->exceptionHandler->render($this->requestMock, new \Illuminate\Auth\Access\AuthorizationException('Unauthorized') );

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class,$response);
    }

   
}