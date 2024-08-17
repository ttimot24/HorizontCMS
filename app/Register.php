<?php

namespace Plugin\EventAndBooking;

use \App\Libs\PluginInterface;

class Register implements PluginInterface
{

	public function webRouteOptions(): array
	{
		return [
			'middleware' => ['web'],
			'namespace' => '\Plugin\EventAndBooking\App',
			'prefix' => '',
		];
	}

	public function apiRouteOptions(): array
	{
		return [
			'middleware' => ['api'],
			'namespace' => '\Plugin\EventAndBooking\App',
			'prefix' => '',
		];
	}

	public function navigation(): array
	{

		return [
			'events' => [
				'label' => trans('Event Manager'),
			],
		];
	}

	public function eventHooks(): array
	{
		return [];
	}


	public function widget(): string
	{
		return "plugin widget";
	}


	public function injectAdminJs(): array
	{
		return [];
	}

	public function injectWebsiteJs(): array
	{
		return [];
	}

	public function onInstall(): void
	{

		$path = "storage/images/events";

		if (!\File::isDirectory($path)) {
			\File::makeDirectory($path);
		}
	}

	public function addProviders(): array
	{
		return [
			\Wpb\String_Blade_Compiler\StringBladeServiceProvider::class,
			\Maatwebsite\Excel\ExcelServiceProvider::class,
		];
	}

	public function addMiddlewares(): array{
		return [];
	}

	public function cliCommands(): array
	{
		return [];
	}
}
