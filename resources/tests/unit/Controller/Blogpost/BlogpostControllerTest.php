<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogpostControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testIndexAction()
    {
        $post = new \App\Model\Blogpost(['title' => 'Test post', 'slug' => 'test-post', 'summary' => 'vmi', 'text' => 'asd', 'category_id' => 1, 'comments_enabled' => 1, 'active' => 1]);
        $post->author_id = 1;
        $post->save();

        \Event::fake();

        $request = Request::create('/admin/blogpost/index', 'GET', []);

        $controller = new \App\Controllers\BlogpostController();

        $responseView = $controller->index($request);

        $this->assertInstanceOf(\Illuminate\View\View::class, $responseView);

        $this->assertEquals('blogposts.index', $responseView->name());

        $this->assertTrue(isset($responseView->getData()['all_blogposts']));
        $this->assertInstanceOf(\App\Model\Blogpost::class, $responseView->getData()['all_blogposts'][0]);
    }

    public function testShowAction()
    {

        $idToTest = 1;

        \Event::fake();

        $request = Request::create('/admin/blogpost/show', 'POST', []);

        $controller = new \App\Controllers\BlogpostController($request);

        $post =  new \App\Model\Blogpost(['title' => 'Test post']);
        $post->id = 1;

        $responseView = $controller->show($request, $post);

        $this->assertInstanceOf(\Illuminate\View\View::class, $responseView);

        $this->assertEquals('blogposts.view', $responseView->name());


        $this->assertTrue(isset($responseView->getData()['blogpost']));
        //  $this->assertFalse(isset($responseView->getData()['previous_blogpost'])); //We checking the first blogpost
        // $this->assertTrue(isset($responseView->getData()['next_blogpost']));
        $this->assertInstanceOf(\App\Model\Blogpost::class, $responseView->getData()['blogpost']);

        $this->assertEquals($idToTest, $responseView->getData()['blogpost']->id);
    }


    public function testCreateAction()
    {

        $category = new \App\Model\BlogpostCategory(['name' => 'def']);
        $category->author_id = 1;
        $category->save();

        \Event::fake();

        $requestGet = Request::create('/admin/blogpost/show', 'GET', []);

        $controller = new \App\Controllers\BlogpostController($requestGet);

        $response = $controller->create();

        $this->assertEquals('blogposts.form', $response->name());
        $this->assertTrue(isset($response->getData()['categories']));
        $this->assertInstanceOf(\App\Model\BlogpostCategory::class, $response->getData()['categories'][0]);

        $requestPost = Request::create('/admin/blogpost/store', 'POST', [
            'title' => 'AutomatedTest',
            'category_ids' => [1],
            'summary' => 'This is the summary of the test blogpost',
            'text' => 'A very long blogpost text',
            'active' => 1
        ]);

        $user =  ModelFactory::createUser(true);
        $user->save();

        $requestPost->setUserResolver(function () use ($user) {
            return $user;
        });

        $controller = new \App\Controllers\BlogpostController();

        $response = $controller->store($requestPost);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

        $this->assertEquals(['success' => trans('message.successfully_created_blogpost')], $response->getSession()->get('message'));
    }
}
