<?php

namespace App\Model\Trait;

trait HasImage
{

    public function attachImage($image)
    {
        $this->image = basename($image);
    }

    public function getImageDirectory()
    {

        return empty($this->imageDir) ? 'storage/images/' . $this->getTable() : rtrim($this->imageDir, DIRECTORY_SEPARATOR);
    }

    public function getThumbnailDirectory()
    {
        return $this->getImageDirectory() . DIRECTORY_SEPARATOR . 'thumbs';
    }

    public function hasImage()
    {
        return (isset($this->image) && !empty($this->image));
    }

    public function imageFileExists()
    {
        return $this->hasImage() && file_exists($this->getImageDirectory() . DIRECTORY_SEPARATOR . $this->image);
    }

    public function thumbnailFileExists()
    {
        return $this->hasImage() && file_exists($this->getThumbnailDirectory() . DIRECTORY_SEPARATOR . $this->image);
    }

    public function getImageFilePath(){
        return $this->getImageDirectory() . DIRECTORY_SEPARATOR . $this->image;
    }

    public function getThumbnailFilePath(){
        return $this->getThumbnailDirectory() . DIRECTORY_SEPARATOR . $this->image;
    }

    public function getThumb()
    {

        if ($this->thumbnailFileExists()) {
            return url($this->getThumbnailFilePath());
        } else {
            return $this->getImage();
        }
    }

    public function getImage()
    {

        if ($this->imageFileExists()) {
            return url($this->getImageFilePath());
        } else {
            return url($this->getDefaultImage());
        }
    }

    public function getFeaturedMediaType(){
        return explode('/', mime_content_type($this->getImageFilePath()))[0];
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
