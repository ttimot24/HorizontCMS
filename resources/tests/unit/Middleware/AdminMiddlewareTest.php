<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminMiddlewareTest extends TestCase
{
    /** @test */
    public function testNonAdminsAreRedirected()
    {
        $permissions = [];

        $user = ModelFactory::createUser(true);
        $user->role->setRightsAttribute($permissions);

        $request = \Request::create('/admin', 'GET');

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
        $permissions = ['admin_area'];

        $user = ModelFactory::createUser();

        $user->role->setRightsAttribute($permissions);

        $request = \Request::create('/admin', 'GET');

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $middleware = new \App\Http\Middleware\AdminMiddleware;

        $response = $middleware->handle($request, function () {});

        $this->assertEquals(302, $response->getStatusCode());
    }
}
