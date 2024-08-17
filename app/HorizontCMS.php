<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;


class HorizontCMS extends \Illuminate\Foundation\Application
{

    // TODO Settings should be added here
    public $plugins;

    public function __construct($basePath = null)
    {
        parent::__construct($basePath);

        $this->plugins = new Collection();
    }

    public static function isInstalled()
    {
        return file_exists(base_path(".env")) || env("INSTALLED", false);
    }

    public function publicPath()
    {
        return $this->basePath . DIRECTORY_SEPARATOR;
    }

    public function setPlugins($plugins){
        $this->plugins = $plugins;
    }

    public function getPlugins(){
        return $this->plugins;
    }

}
