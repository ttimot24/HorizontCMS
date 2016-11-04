<?php

namespace App\Libs;

class DotEnvGenerator
{
    private $content = '';
    private $path = '';
    private $file = '.env';

    public function setPath($path)
    {
        $this->path = $path.'/';
    }

    public function addEnvVar($var, $val)
    {
        $this->content .= strtoupper($var).'='.$val."\r\n";
    }

    public function generate()
    {
        file_put_contents($this->path.$this->file, $this->content);
    }
}
