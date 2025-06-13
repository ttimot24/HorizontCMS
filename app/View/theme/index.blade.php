@extends('layout', ['title' => trans('theme.themes')])

@section('content')
    <div class='container'>

        <div class="card mb-3">


            @include('breadcrumb', [
                'links' => [['name' => 'Content'], ['name' => trans('Themes'), 'url' => route('theme.index')]],
                'page_title' => trans('theme.themes'),
                'stats' => [['label' => trans('theme.all'), 'value' => $all_themes->count()]],
                'buttons_right' => [
                    [
                        'icon' => 'fa-cloud-download',
                        'label' => 'Download themes',
                        'route' => config('horizontcms.backend_prefix') . '/theme/onlinestore',
                        'class' => 'btn-info',
                    ],
                    [
                        'icon' => 'fa-upload',
                        'label' => trans('theme.upload_theme_button'),
                        'class' => 'btn-primary',
                        'data' => 'data-bs-toggle=modal data-bs-target=.upload_theme',
                    ],
                ],
            ])


            <div class="card-body">

                <div class='col-md-12'>
                    <div class='jumbotron' style='background-color:#31708F;'>
                        <div class='row'>
                            <div class='col-xs-12 col-md-5'>
                                <div class='thumbnail pt-3'>
                                    <img class="img img-thumbnail w-100" src="{{ $active_theme->getImage() }}" />
                                </div>
                            </div>
                            <div class='col-xs-12 col-md-7'>
                                <h1>{{ $active_theme->getName() }}</h1>
                                <h4 class="text-muted">{{ trans('theme.version') }}: {{ $active_theme->getInfo('version') }}
                                </h4>
                                <h4>{{ trans('theme.is_the_current_theme') }}</h4>
                                <p>{{ $active_theme->getInfo('description') }}</p>
                                @if ($active_theme->getSupportedLanguages()->count() > 0)
                                    <p style='font-size:1em'>{{ trans('theme.supported_lang') }}:
                                        {{ implode(', ', $active_theme->getSupportedLanguages()->toArray()) }}</p>
                                @endif
                                <p style='font-size:1em'>{{ trans('theme.author') }}: {{ $active_theme->getInfo('author') }}
                                    |
                                    {{ trans('theme.website') }}: <a target='_blank'
                                        href='<?= UrlManager::http_protocol($active_theme->getInfo('author_url'))
                                        ?>'>{{ $active_theme->getInfo('author_url') }}</a></p>
                            </div>
                        </div>
                    </div>


                    <div class="container row">
                        <?php foreach($all_themes as $theme): ?>

                        <div class='col-sm-6 col-md-4 g-2 float-left'>
                            <div class="card p-2 bg-dark">
                                <img class="card-img-top" src="<?= $theme->getImage() ?>" style="height:15rem;"
                                    alt="Theme screenshot">
                                <div class="card-body text-white">
                                    <h3><?= $theme->getName() ?></h3>
                                    <p>version: <?= $theme->getInfo('version') ?> | author: <?= $theme->getInfo('author') ?>
                                    </p>
                                    <p class="mb-0">
                                        <a href='admin/theme/set/<?= $theme->getRootDir() ?>'
                                            class="btn btn-primary <?php if ($theme->isCurrentTheme()) {
                                                echo 'disabled';
                                            } ?> " role="button">Activate</a>
                                        <!--<a href="#" class="btn btn-default" role="button" data-toggle='modal' data-target='.<?= $theme->getRootDir() ?>-modal-xl'>Preview</a>-->
                                        <a href='admin/theme/options/<?= $theme->getRootDir() ?>' class="btn btn-warning"
                                            role="button">{{ trans('actions.options') }}</a>
                                        <button class='btn btn-danger' data-bs-toggle='modal'
                                            data-bs-target='#delete_<?= $theme->getRootDir() ?>'
                                            <?php if ($all_themes->count() == 1) {
                                                echo 'disabled';
                                            } ?>>{{ trans('actions.delete') }}</button>
                                    </p>
                                </div>
                            </div>
                        </div>

                        @include('confirm_delete', [
                            'route' => route('theme.destroy', ['theme' => $theme->getRootDir()]),
                            'id' => 'delete_' . $theme->getRootDir(),
                            'header' => trans('actions.are_you_sure'),
                            'name' => $theme->getName(),
                            'content_type' => 'theme',
                            'delete_text' => trans('actions.delete'),
                            'cancel' => trans('actions.cancel'),
                        ])

                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

        </div>

    </div>
    </div>


    <div class='modal upload_theme' id='create_file' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
        aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header modal-header-primary bg-primary'>
                    <h4 class='modal-title text-white'>New file</h4>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>

                    <form action="{{ route('theme.store') }}" method='POST' enctype='multipart/form-data'>
                        @csrf
                        <div class='form-group'>
                            <label for='file'>Upload file:</label>
                            <input name='up_file[]' id='input-2' type='file' class='file' accept='.zip'
                                multiple='true' data-show-upload='false' data-show-caption='true' required>
                        </div>


                </div>
                <div class='modal-footer'>
                    <button type='submit' class='btn btn-primary'>{{ trans('actions.upload') }}</button></form>
                    <button type='button' class='btn btn-default'
                        data-bs-dismiss='modal'>{{ trans('actions.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
