<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchEngineTest extends TestCase
{


    protected function setUp() : void {
        parent::setUp();
        $this->engine = new \App\Libs\SearchEngine();
    }

    /**
     * A test for route resolving
     *
     * @return void
     */
    public function testSearchEngineInitiation(){


        $this->assertInstanceOf(\App\Libs\SearchEngine::class,$this->engine);
        
        $this->assertObjectHasAttribute('searchModels',$this->engine);
        $this->assertObjectHasAttribute('searchKey',$this->engine);
    }


    public function testRoutingMethodExistance(){


         $methods = [
                    'registerModel',
                    'executeSearch',
                    'getResultsFor',
                    ];

         foreach($methods as $method){
            $this->assertTrue(method_exists($this->engine, $method),'Method ['.$method.'] does not exists in class ['.get_class($this->engine).']');
         }


    }


    public function testGetterAndSetterModel(){

       $this->assertIsArray($this->engine->getRegisteredModels());
       $this->assertEquals(0,count($this->engine->getRegisteredModels()));
       $this->engine->registerModel(\App\Model\Page::class);
       $this->assertEquals(1,count($this->engine->getRegisteredModels()));

       $this->assertEquals(0,count($this->engine->getResultsFor(\App\Libs\Page::class)));

    }

    public function testExecuteSearch(){
    
        $this->engine->registerModel(\App\Model\Page::class);
        $this->engine->executeSearch('home'); 
        $this->assertEquals(1,count($this->engine->getResultsFor(\App\Model\Page::class)));

    }

    public function testClearResults(){
        $this->engine->registerModel(\App\Model\Page::class);
        $this->engine->executeSearch('home'); 
        $this->assertEquals(1,count($this->engine->getResultsFor(\App\Model\Page::class)));
        $this->engine->clearResults();
        $this->assertEquals(0,count($this->engine->getResultsFor(\App\Model\Page::class)));

    }

    public function testSearchKey(){
        $this->engine->executeSearch('home'); 
        $this->assertEquals('home',$this->engine->getSearchKey());
        $this->engine->clearResults();
        $this->assertEquals(null,$this->engine->getSearchKey());
    }

}
