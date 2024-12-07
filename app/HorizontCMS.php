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
        return config('horizontcms.installed');
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
