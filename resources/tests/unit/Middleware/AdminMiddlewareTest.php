<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Http\Request;

class AdminMiddlewareTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function testNonAdminsAreRedirected()
    {
        $permissions = [];

        $user = ModelFactory::createUser(true);
        $user->save();
        $user->role = new \App\Model\UserRole(['name' => 'admin']);
        $user->role->setRightsAttribute($permissions);

        $request = Request::create('/admin', 'GET');

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $middleware = new \App\Http\Middleware\AdminMiddleware;

        $response = $middleware->handle($request, function () {});

        $this->assertEquals(302, $response->getStatusCode());
    }


    /** @test */
    public function testAdminsAreNotRedirected()
    {
        $permissions = ['admin_area'];

        $user = ModelFactory::createUser(true);
        $user->save();
        $user->role = new \App\Model\UserRole(['name' => 'admin']);
        $user->role->setRightsAttribute($permissions);

        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $middleware = new \App\Http\Middleware\AdminMiddleware;

        $response = $middleware->handle($request, function () {});

        $this->assertEquals(null, $response);
    }


    /** @test */
    public function testNonActiveAdminsAreRedirected()
    {

        $user = ModelFactory::createUser(false);

        $request = Request::create('/admin', 'GET');

        $request->setUserResolver(function () use ($user) {

            $role = new \App\Model\UserRole(['name' => 'admin']);
            $role->setRightsAttribute(['admin_area']);
            $user->role = $role;

            return $user;
        });

        $middleware = new \App\Http\Middleware\AdminMiddleware();

        $response = $middleware->handle($request, function () {});

        $this->assertEquals(302, $response->getStatusCode());
    }
}
