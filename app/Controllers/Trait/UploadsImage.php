<?php

namespace App\Controllers\Trait;

use TypeError;

trait UploadsImage {

    protected $form_field_name = 'up_file';

    private function getStrippedDirectoryPath($model){
        return str_replace('storage/', '', $model->getImageDirectory());
    }

    public function uploadImage($model): bool {

        if(in_array('HasImage', class_uses($model, true))){
           throw new TypeError('Class['.get_class($model).'] does not use HasImage trait');
        }

        if (request()->hasFile($this->form_field_name)) {

            \File::ensureDirectoryExists($this->getStrippedDirectoryPath($model));
            $img = request()->up_file->store($this->getStrippedDirectoryPath($model));
            $model->attachImage($img);
            if (extension_loaded('gd')) {

		        \File::ensureDirectoryExists($this->getStrippedDirectoryPath($model) . '/thumbs');
                \Intervention\Image\ImageManagerStatic::make(storage_path($img))->fit(300, 200)->save($model->getThumbnailDirectory(). DIRECTORY_SEPARATOR . $model->image);
            }

            return true;
        }
        
        return false;
    }

}