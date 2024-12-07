<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class InstallerMiddlewareTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function testNotRedirectIfInstalled()
    {
        $request = \Request::create('/admin/dashboard', 'GET');

        $middleware = new \App\Http\Middleware\InstallerMiddleware;

        $response = $middleware->handle($request, function () {});

        $this->assertNull($response);
    }

    /** @test */
    public function testInstallerIsNotAvailableAfterInstalled()
    {
        $request = \Request::create('/admin/install', 'GET');

        $middleware = new \App\Http\Middleware\InstallerMiddleware;

        $response = $middleware->handle($request, function () {});

        $this->assertNotNull($response);
        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals($response->headers->get('Location'), \Config::get('app.url') . '/admin/login');
    }
}
