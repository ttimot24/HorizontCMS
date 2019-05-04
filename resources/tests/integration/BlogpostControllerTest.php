<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogpostControllerTest extends TestCase{

    public function testIndexAction(){

        \Event::fake();

        $request = Request::create('/admin/blogpost/index', 'POST',[]);

        $controller = new \App\Controllers\BlogpostController($request, new \App\Libs\ViewResolver());

        $responseView = $controller->index(null);

        $this->assertInstanceOf(\Illuminate\View\View::class,$responseView);

        $this->assertEquals('blogposts.index', $responseView->name());


        $this->assertTrue(isset($responseView->getData()['number_of_blogposts']));
        $this->assertTrue(isset($responseView->getData()['all_blogposts']));
        $this->assertInstanceOf(\App\Model\Blogpost::class,$responseView->getData()['all_blogposts'][0]);
    }


}