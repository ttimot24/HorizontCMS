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

        if ($this->hasImage() && file_exists(rtrim($this->imageDir, DIRECTORY_SEPARATOR) . "/thumbs/" . $this->image)) {
            return url(rtrim($this->imageDir, DIRECTORY_SEPARATOR). "/thumbs/" . $this->image);
        } else {
            return $this->getImage();
        }
    }

    public function getImage()
    {
        if ($this->hasImage() && file_exists(rtrim($this->imageDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $this->image)) {
            return url(rtrim($this->imageDir, DIRECTORY_SEPARATOR) . "/" . $this->image);
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
