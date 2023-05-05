<file-manager :mode="'{{ $mode }}'" :directory="'{{ $current_dir }}'" :disks='{!! json_encode( array_keys(collect(config('filesystems.disks'))->map(function($disk){
    return isset($value["root"]) ? basename($value["root"]) : "";
})->toArray())) !!}'>                     

</file-manager>