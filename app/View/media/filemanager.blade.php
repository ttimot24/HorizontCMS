    <div class='container main-container'>

        <div class="card mb-3">

        @if($mode!=='embed')
            @include('breadcrumb', [
                'links' => [['name' => 'Content'], ['name' => trans('Media')]],
                'page_title' => trans('File manager'),
            ])
        @endif

            <file-manager :mode="'{{ $mode }}'" :directory="'{{ $current_dir }}'"
                :disks='{!! json_encode(
                    array_keys(
                        collect(config('filesystems.disks'))->map(function ($disk) {
                                return isset($value['root']) ? basename($value['root']) : '';
                            })->toArray(),
                    ),
                ) !!}'>

            </file-manager>

        </div>
    </div>
