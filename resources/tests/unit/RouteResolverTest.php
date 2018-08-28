<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RouteResolverTest extends TestCase
{


    /** @before */
    public function instantiateRouter(){

        $this->router = new \App\Http\RouteResolver();
    }

    /**
     * A test for route resolving
     *
     * @return void
     */
    public function testRoutingInitiation(){


        $this->assertInstanceOf(\App\Http\RouteResolver::class,$this->router);
        
        $this->assertObjectHasAttribute('defaultNamespace',$this->router);
        $this->assertObjectHasAttribute('namespace',$this->router);


    }


    public function testRoutingMethodExistance(){


         $methods = [
                    'resetNamespace',
                    'changeNamespace',
                    'resolveControllerClass',
                    'resolve'
                    ];

         foreach($methods as $method){
            $this->assertTrue(method_exists($this->router, $method),'Method ['.$method.'] does not exists in class ['.get_class($this->router).']');
         }


    }


    public function testRouteNamespacing(){

        $defaultNamespace = "\App\\Controllers\\";

        $this->assertEquals($this->router->namespace,$defaultNamespace);

        $changeNamespaceTo = "\App\TestingNamespace";

        $this->router->changeNamespace($changeNamespaceTo);

        $this->assertEquals($this->router->namespace,$changeNamespaceTo);

        $this->router->resetNamespace();

        $this->assertEquals($this->router->namespace,$defaultNamespace);

    }



    public function testControllerResolving(){

        $controllerString = 'install';


        $this->assertInstanceOf(\App\Libs\Controller::class,\App::make($this->router->resolveControllerClass($controllerString)));
        $this->assertInstanceOf(\App\Controllers\InstallController::class,\App::make($this->router->resolveControllerClass($controllerString)));

        $this->router->changeNamespace("\App\\Controllers\\Auth\\"); 

        $controllerString = 'login';

        $this->assertInstanceOf(\App\Controllers\Auth\LoginController::class,\App::make($this->router->resolveControllerClass($controllerString)));


    }




}
