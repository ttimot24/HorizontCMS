<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Http\Request;
use \App\Model\Settings;

class SettingsMiddlewareTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function testSettingsAreSet()
    {

        \Config::set('horizontcms.installed', true);

        $request = new Request;

        $middleware = new \App\Http\Middleware\SettingsMiddleware(new Settings());

        $middleware->handle($request, function ($req) {
            $this->assertNotNull($req->settings);
        });
    }
}
