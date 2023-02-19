<?php

namespace App\Libs;

interface PluginInterface {

    public function routeOptions(): array;

	public function navigation(): array;

	public function eventHooks(): array;

	public function widget(): string;

    public function injectWebsiteJs(): array;

	public function injectAdminJs(): array;

	public function onInstall(): void;

	public function addProviders(): array;

    public function cliCommands(): array;

}