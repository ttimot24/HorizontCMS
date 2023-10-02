<?php

namespace App\Libs;

class Theme
{

	public $languagePath = "resources/lang";

	public function __construct($root_dir)
	{
		$this->root_dir = $root_dir;
		//$this->info = file_exists($this->getPath()."theme_info.xml")? simplexml_load_file($this->getPath()."theme_info.xml") : NULL;

		$this->parseThemeInfo();

		$this->config = file_exists($this->getPath() . "config.php") ? require($this->getPath() . "config.php") : NULL;
	}


	public function templates()
	{

		if (file_exists('themes' . DIRECTORY_SEPARATOR . $this->root_dir . DIRECTORY_SEPARATOR . 'page_templates')) {
			return array_slice(scandir('themes' . DIRECTORY_SEPARATOR . $this->root_dir . DIRECTORY_SEPARATOR . 'page_templates'), 2);
		} else {
			new \Exception('Couldn\'t render the theme!');
		}

		return [];
	}

	public function parseThemeInfo()
	{

		$file_without_extension = $this->getPath() . "theme_info";

		if (file_exists($file_without_extension . ".yml") && class_exists('\Symfony\Component\Yaml\Yaml')) {
			$this->info = \Symfony\Component\Yaml\Yaml::parse(
				file_get_contents($file_without_extension . ".yml"),
				\Symfony\Component\Yaml\Yaml::PARSE_OBJECT
			);
		} else if (file_exists($file_without_extension . ".json")) {
			$this->info = json_decode(file_get_contents($file_without_extension . ".json"));
		} else if (file_exists($file_without_extension . ".xml")) {
			$this->info = simplexml_load_file($file_without_extension . ".xml");
		} else {
			$this->info = NULL;
		}
	}

	public function isCurrentTheme()
	{
		return $this->root_dir == \Settings::get('theme');
	}

	public function getConfig($config, $default = NULL)
	{
		return isset($this->config[$config]) ? $this->config[$config] : $default;
	}

	public function getName()
	{
		return $this->getInfo('name') == NULL ? $this->root_dir : $this->getInfo('name');
	}


	public function getPath()
	{
		return 'themes/' . $this->root_dir . '/';
	}

	public function getSupportedLanguages()
	{
		$lang_dir = $this->getPath() . $this->languagePath;

		if (!file_exists($lang_dir)) {
			return collect();
		}

		return collect(array_slice(scandir($lang_dir), 2))->filter(function ($lang) {
			return substr_compare($lang, ".json", -strlen(".json")) === 0;
		})->map(function ($lang) {
			return str_replace('.json', '', $lang);
		});
	}

	public function getImage()
	{
		return $this->getPath() . "preview.jpg";
	}

	public function getInfo($info)
	{
		return isset($this->info->{$info}) ? $this->info->{$info} : NULL;
	}

	public function has404Template()
	{
		return (file_exists($this->getPath() . "404.blade.php") || file_exists($this->getPath() . "404.php"));
	}

	public function hasWebsiteDownTemplate()
	{
		return (file_exists($this->getPath() . "website_down.blade.php") || file_exists($this->getPath() . "website_down.php"));
	}

	public function getRequiredCoreVersion()
	{
		return isset($this->getInfo('requires')->core) ? $this->getInfo('requires')->core : NULL;
	}

	public function isCompatibleWithCore()
	{
		return \Composer\Semver\Comparator::greaterThanOrEqualTo(\App\Model\SystemUpgrade::getCurrentVersion()->version, $this->getRequiredCoreVersion());
	}
}
