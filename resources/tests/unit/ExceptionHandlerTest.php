<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExceptionHandler extends TestCase
{

    private $requestMock;
    private $exceptionHandler;

    /** @before */
    public function instantiateExceptionHandler()
    {

        $this->requestMock = \Mockery::mock(\Illuminate\Http\Request::class)->makePartial();
        $this->requestMock->headers = new \Symfony\Component\HttpFoundation\HeaderBag([]);

        $this->exceptionHandler = new \App\Exceptions\Handler($this->createMock(\Illuminate\Contracts\Container\Container::class));
    }

    public function testRenderAuthorizationException()
    {
        $response = $this->exceptionHandler->render($this->requestMock, new \Illuminate\Auth\Access\AuthorizationException('Unauthorized'));

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }


    public function testRenderAuthenticationException()
    {

        $response = $this->exceptionHandler->render($this->requestMock, new \Illuminate\Auth\AuthenticationException('Unauthenticated'));

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

        $this->requestMock->headers->set('Accept', 'application/json');
        $this->requestMock->headers->set('Content-Type', 'application/json');
        $this->requestMock->headers->set('X-Requested-With', 'XMLHttpRequest');

        $response = $this->exceptionHandler->render($this->requestMock, new \Illuminate\Auth\AuthenticationException('Unauthenticated'));

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
    }

    public function testRenderAllExceptions()
    {
        $response = $this->exceptionHandler->render($this->requestMock, new \Exception('Any exception'));

        $this->assertInstanceOf(\Illuminate\Http\Response::class, $response);
    }

    /* TODO test dontReport */
    /* public function testReport(){
        $response = $this->exceptionHandler->report(new \Exception('Any exception'));
    }*/
}
