<?php

namespace App\Services;

class BladeThemeEngine
{

	protected $theme;
	protected $page_template = 'index';
	public $request;

	public function __construct(\Illuminate\Http\Request $request)
	{
		$this->request = $request;
	}

	public function getTheme()
	{
		return $this->theme;
	}

	public function setTheme(\App\Services\Theme $theme)
	{
		$this->theme = $theme;
	}

	public function pageTemplate($page_template)
	{
		$this->page_template = $page_template;
	}

	public function defaultTemplateExists($template)
	{
		return file_exists($this->theme->getPath() . $template . '.blade.php');
	}

	public function templateExists($template)
	{
		return file_exists($this->theme->getPath() . "page_templates" . DIRECTORY_SEPARATOR . $template);
	}


	public function render(array $data)
	{

		$default_data = [
			'_THEME_PATH' => str_replace(DIRECTORY_SEPARATOR, '/', $this->theme->getPath()),
		];


		\View::addNamespace('theme', base_path($this->theme->getPath()));


		return view('theme::' . str_replace('.blade.php', '', $this->page_template), array_merge($default_data, $data));
	}


	public function runScript($script_name)
	{
		if ($this->theme->getConfig($script_name)) {
			return call_user_func($this->theme->getConfig($script_name));
		}

		return NULL;
	}


	public function render404()
	{

		if ($this->theme->has404Template()) {
			$this->page_template = "404";
		} else {
			$this->page_template = "default.404";
		}
	}

	public function renderWebsiteDown()
	{
		if ($this->theme->hasWebsiteDownTemplate()) {
			$this->page_template = "website_down";
		} else {
			$this->page_template = "default.website_down";
		}
	}
}
