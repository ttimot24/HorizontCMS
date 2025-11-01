<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogpostApiTest extends TestCase
{

    use RefreshDatabase;


    public function setUpData()
    {

        $category = new \App\Model\BlogpostCategory(['name' => 'Test category', 'slug' => 'test-category', 'description' => 'asd', 'active' => 1]);
        $category->author_id = 1;
        $category->save();

        $post1 = new \App\Model\Blogpost(['title' => 'Test post', 'slug' => 'test-post', 'summary' => 'vmi', 'text' => 'asd', 'comments_enabled' => 1, 'author_id' => 1, 'active' => 1]);
        $post1->save();
        $post1->categories()->attach($category->id);
        $post1->save();

        $post2 = new \App\Model\Blogpost(['title' => 'Second post', 'slug' => 'second-post', 'summary' => 'vmi', 'text' => 'asd', 'comments_enabled' => 1, 'author_id' => 1, 'active' => 1]);
        $post2->save();
        $post2->categories()->attach($category->id);
        $post2->save();

        return ['category' => $category, 'post1' => $post1, 'post2' => $post2 ];
    }

    public function testIndexApiAction()
    {

        $data = $this->setUpData();

        \Event::fake();

        $request = Request::create('/admin/blogpost/index', 'GET', [
        'size' => 1,
        'page' => 1,
        'sort' => ['id' => 'desc'],
        'with' => ['categories']
        ], [], [], ['HTTP_ACCEPT' => 'application/json']);

        $controller = new \App\Controllers\BlogpostController();

        $response = $controller->index($request);

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);

        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue(isset($responseData['data']));
   //     $this->assertEquals(1, count($responseData['data'])); // TODO fix this
        $this->assertInstanceOf(\App\Model\Blogpost::class, (new \App\Model\Blogpost($responseData['data'][0])));
    //    $this->assertEquals($post2->id, $responseData['data'][0]['id']); // fix this Sorted by desc, so the second post is first
        $this->assertInstanceOf(\App\Model\BlogpostCategory::class, (new \App\Model\BlogpostCategory($responseData['data'][0]['categories'][0])));
    }


    public function testShowApiAction()
    {

        $data = $this->setUpData();

        \Event::fake();

        $request = Request::create('/admin/blogpost/index/1', 'GET', [
        'with' => ['categories']
        ], [], [], ['HTTP_ACCEPT' => 'application/json']);

        $controller = new \App\Controllers\BlogpostController();

        $response = $controller->show($request, $data['post1']);

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);

        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

        $this->assertInstanceOf(\App\Model\Blogpost::class, (new \App\Model\Blogpost($responseData)));

        $this->assertInstanceOf(\App\Model\BlogpostCategory::class, (new \App\Model\BlogpostCategory($responseData['categories'][0])));
    }

}
