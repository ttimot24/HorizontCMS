<?php

namespace App\Model\Trait;

trait HasImage
{

    public function hasImage()
    {
        return (isset($this->image) && !empty($this->image));
    }

    public function getThumb()
    {

        if ($this->hasImage() && file_exists($this->imageDir . "/thumbs/" . $this->image)) {
            return url($this->imageDir . "/thumbs/" . $this->image);
        } else {
            return $this->getImage();
        }
    }

    public function getImage()
    {

        if ($this->hasImage() && file_exists($this->imageDir . "/" . $this->image)) {
            return url($this->imageDir . "/" . $this->image);
        } else {
            return url($this->getDefaultImage());
        }
    }

    public function getDefaultImage()
    {
        return $this->defaultImage;
    }


    public function setDefaultImage($image)
    {
        $this->defaultImage = $image;
    }
}
