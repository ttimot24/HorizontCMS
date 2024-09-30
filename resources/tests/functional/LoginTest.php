<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{

	/** @before */
	public function checkIfCMSIsInstalled()
	{

		if (!\App\HorizontCMS::isInstalled()) {
			echo "HorizontCMS is not installed! Tests are stopped!";
			exit;
		}
	}

	/** @before */
	public function createTestUser()
	{

		if (!isset($this->user)) {
			$this->user = factory(\App\Model\User::class)->create([
				'role_id' => '6',
				'password' => 'testpass123'
			]);
		}
	}

	public function testOpenLoginPage()
	{

		$this->visit(\Config::get('horizontcms.backend_prefix'))
			->seePageIs(\Config::get('horizontcms.backend_prefix') . "/login")
			->see('HorizontCMS')
			->see('Closer to the web');
	}

	public function testInvalidCredentials()
	{

		$this->visit(\Config::get('horizontcms.backend_prefix'))
			->type($this->user->username, 'username')
			->type('wrongpassword', 'password')
			->press('submit_login')
			->seePageIs(\Config::get('horizontcms.backend_prefix') . "/login")
			->see('These credentials do not match our records.');
	}
}
