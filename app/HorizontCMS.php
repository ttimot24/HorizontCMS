<?php

namespace App;

use Illuminate\Support\Collection;


class HorizontCMS extends \Illuminate\Foundation\Application
{

    // TODO Settings should be added here
    public Collection $plugins;

    public function __construct($basePath = null)
    {
        parent::__construct($basePath);

        $this->plugins = new Collection();
    }

    public static function isInstalled()
    {
        return file_exists(base_path(".env")) || config('horizontcms.installed', false);
    }

    public function publicPath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR;
    }

    public function setPlugins(Collection $plugins){
        $this->plugins = $plugins;
    }

    public function getPlugins(): Collection {
        return $this->plugins;
    }

}
