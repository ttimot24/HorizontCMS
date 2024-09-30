<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @deprecated deprecated since version 1.0.0
 */
class RouteResolverTest extends TestCase
{

    private $router;

    /** @before */
    public function instantiateRouter()
    {

        $this->router = new \App\Http\RouteResolver();
    }

    /**
     * A test for route resolving
     *
     * @return void
     */
    public function testRoutingInitiation()
    {


        $this->assertInstanceOf(\App\Http\RouteResolver::class, $this->router);

        $this->assertObjectHasProperty('defaultNamespace', $this->router);
        $this->assertObjectHasProperty('namespace', $this->router);
    }


    public function testRoutingMethodExistance()
    {


        $methods = [
            'resetNamespace',
            'changeNamespace',
            'resolveControllerClass',
            'resolve'
        ];

        foreach ($methods as $method) {
            $this->assertTrue(method_exists($this->router, $method), 'Method [' . $method . '] does not exists in class [' . get_class($this->router) . ']');
        }
    }


    public function testRouteNamespacing()
    {

        $defaultNamespace = "\App\\Controllers\\";

        $this->assertEquals($this->router->namespace, $defaultNamespace);

        $changeNamespaceTo = "\App\TestingNamespace";

        $this->router->changeNamespace($changeNamespaceTo);

        $this->assertEquals($this->router->namespace, $changeNamespaceTo);

        $this->router->resetNamespace();

        $this->assertEquals($this->router->namespace, $defaultNamespace);
    }



    public function testControllerResolving()
    {

        $controllerString = 'install';

        $this->assertInstanceOf(\App\Controllers\InstallController::class, \App::make($this->router->resolveControllerClass($controllerString)));

        $this->router->changeNamespace("\App\\Controllers\\Auth\\");

        $controllerString = 'login';

        $this->assertInstanceOf(\App\Controllers\Auth\LoginController::class, \App::make($this->router->resolveControllerClass($controllerString)));
    }

    public function testControllerNotExsistException()
    {

        $controllerString = 'notexistingcontrollername';

        $this->expectException(\App\Exceptions\FileNotFoundException::class);

        $this->router->resolveControllerClass($controllerString);
    }


    public function testRouteNotExsistsExceptionIsThrown()
    {

        $this->expectException(\BadMethodCallException::class);

        $this->router->resolve('dashboard', 'missing-method'); //53
    }
}
