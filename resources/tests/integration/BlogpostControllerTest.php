<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogpostControllerTest extends TestCase{

    public function testIndexAction(){

        \Event::fake();

        $request = Request::create('/admin/blogpost/index', 'GET',[]);

        $controller = new \App\Controllers\BlogpostController($request, new \App\Libs\ViewResolver());

        $responseView = $controller->index(null);

        $this->assertInstanceOf(\Illuminate\View\View::class,$responseView);

        $this->assertEquals('blogposts.index', $responseView->name());


        $this->assertTrue(isset($responseView->getData()['number_of_blogposts']));
        $this->assertTrue(isset($responseView->getData()['all_blogposts']));
        $this->assertInstanceOf(\App\Model\Blogpost::class,$responseView->getData()['all_blogposts'][0]);
    }


    public function testShowAction(){

        $idToTest = 1;

        \Event::fake();

        $request = Request::create('/admin/blogpost/show', 'POST',[]);

        $controller = new \App\Controllers\BlogpostController($request, new \App\Libs\ViewResolver());

        $responseView = $controller->show($idToTest);

        $this->assertInstanceOf(\Illuminate\View\View::class,$responseView);

        $this->assertEquals('blogposts.view', $responseView->name());


        $this->assertTrue(isset($responseView->getData()['blogpost']));
      //  $this->assertFalse(isset($responseView->getData()['previous_blogpost'])); //We checking the first blogpost
       // $this->assertTrue(isset($responseView->getData()['next_blogpost']));
        $this->assertInstanceOf(\App\Model\Blogpost::class,$responseView->getData()['blogpost']);
        
        $this->assertEquals($idToTest,$responseView->getData()['blogpost']->id);
    }


    public function testCreateAction(){
        
        \Event::fake();

        $requestGet = Request::create('/admin/blogpost/show', 'GET',[]);

        $controller = new \App\Controllers\BlogpostController($requestGet, new \App\Libs\ViewResolver());

        $response = $controller->create();

        $this->assertEquals('blogposts.create', $response->name());
        $this->assertTrue(isset($response->getData()['categories']));
        $this->assertInstanceOf(\App\Model\BlogpostCategory::class,$response->getData()['categories'][0]);

        $requestPost = Request::create('/admin/blogpost/show', 'POST',[
            'title' => 'AutomatedTest',
            'category_id' => 1,
            'summary' => 'This is the summary of the test blogpost',
            'text' => 'A very long blogpost text',
            'active' => 1
        ]);
        
        $user = \App\Model\User::find(1);
        
        $requestPost->setUserResolver(function () use ($user) {
            return $user;
        });

        $controller = new \App\Controllers\BlogpostController($requestPost, new \App\Libs\ViewResolver());

        $response = $controller->create();

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class,$response);    

        $this->assertEquals(['success' => trans('message.successfully_created_blogpost')],$response->getSession()->get('message'));
        
    }



}