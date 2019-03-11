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

        $user = factory(\App\Model\User::class)->make(['active' => 1]);
        $user->role = new \App\Model\UserRole;
        $user->role->setRightsAttribute($permissions);

        $request = \Request::create('/admin', 'GET');

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $middleware = new \App\Http\Middleware\AdminMiddleware;

        $response = $middleware->handle($request, function () { });

        $this->assertEquals($response->getStatusCode(), 302); 
    }


    /** @test */
    public function testAdminsAreNotRedirected()
    {
        $permissions = ['admin_area'];

        $user = factory(\App\Model\User::class)->make(['active' => 1 ]);
        $user->role = new \App\Model\UserRole;
        $user->role->setRightsAttribute($permissions);

        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $middleware = new \App\Http\Middleware\AdminMiddleware;

        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response, null);
    }
    

    /** @test */
    public function testNonActiveAdminsAreRedirected()
    {
        $permissions = ['admin_area'];

        $user = factory(\App\Model\User::class)->make(['active' => 0]);
        $user->role = new \App\Model\UserRole;
        $user->role->setRightsAttribute($permissions);

        $request = \Request::create('/admin', 'GET');

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $middleware = new \App\Http\Middleware\AdminMiddleware;

        $response = $middleware->handle($request, function () { });

        $this->assertEquals($response->getStatusCode(), 302); 
    }

}