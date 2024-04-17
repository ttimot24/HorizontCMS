<?php

namespace App\Controllers\Trait;

use TypeError;
use Illuminate\Support\Facades\File;

trait UploadsImage {

    protected $form_field_name = 'up_file';

    private function getStrippedDirectoryPath($model){
        return str_replace('storage/', '', $model->getImageDirectory());
    }

    public function uploadImage($model): bool {

        if(!in_array('App\Model\Trait\HasImage', class_uses($model, true))){
           throw new TypeError('Class['.get_class($model).'] does not use HasImage trait');
        }

        if (request()->hasFile($this->form_field_name)) {

            File::ensureDirectoryExists($model->getImageDirectory());
            $img = request()->{$this->form_field_name}->store($this->getStrippedDirectoryPath($model));
            $model->attachImage($img);
            if (extension_loaded('gd')) {
		        File::ensureDirectoryExists($model->getImageDirectory() . '/thumbs');
                \Intervention\Image\ImageManagerStatic::make(storage_path($img))->fit(300, 200)->save($model->getThumbnailDirectory(). DIRECTORY_SEPARATOR . $model->image);
            }

            return true;
        }
        
        return false;
    }

}