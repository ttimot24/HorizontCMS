<?php

namespace App\Libs;

class Theme
{
    public function __construct($root_dir)
    {
        $this->root_dir = $root_dir;
        $this->info = simplexml_load_file($this->getPath().'theme_info.xml');
    }

    public function templates()
    {
        if (file_exists('themes/'.$this->root_dir.'/page_templates')) {
            return array_slice(scandir('themes/'.$this->root_dir.'/page_templates'), 2);
        } else {
            new \Exception('Couldn\'t render the theme!');
        }

        return [];
    }

    public function getPath()
    {
        return 'themes'.DIRECTORY_SEPARATOR.$this->root_dir.DIRECTORY_SEPARATOR;
    }

    public function getImage()
    {
        return $this->getPath().'preview.jpg';
    }

    public function getInfo($info)
    {
        return isset($this->info->{$info}) ? $this->info->{$info} : null;
    }

    public function has404Template()
    {
        return file_exists($this->getPath().'404.blade.php') || file_exists($this->getPath().'404.php');
    }

    public function hasWebsiteDownTemplate()
    {
        return file_exists($this->getPath().'website_down.blade.php') || file_exists($this->getPath().'website_down.php');
    }
}
