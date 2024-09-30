<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class SettingsMiddlewareTest extends TestCase
{
    /** @test */
    public function testSettingsAreSet()
    {
        $request = new Request;

        $middleware = new \App\Http\Middleware\SettingsMiddleware;

        $middleware->handle($request, function ($req) {
            $this->assertNotNull($req->settings);
        });
    }
}
