@extends('layout')

@section('content')
    <div class='container'>

        <div class="card mb-3">

            @include('breadcrumb', [
                'links' => [
                    ['name' => 'Content'],
                    ['name' => trans('Themes'), 'url' => route('theme.index')],
                    ['name' => $theme],
                ],
                'page_title' => trans('Theme options'),
            ])


            <div class="card-body">

                <div class="d-flex align-items-start pt-4">
                    <div class="nav flex-column nav-pills me-3 col-2" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-style-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-style" type="button" role="tab" aria-controls="v-pills-style"
                            aria-selected="true">Custom style</button>
                        <button class="nav-link" id="v-pills-translate-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-translate" type="button" role="tab"
                            aria-controls="v-pills-translate" aria-selected="false">Translations</button>
                    </div>
                    <div class="col-10">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-style" role="tabpanel"
                                aria-labelledby="v-pills-style-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="m-0 p-0">Custom Style</h3>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <form action='{{ route('settings.store') }}' role='form' method='POST'>
                                                @csrf
                                                <textarea rows="20" class='form-control' name="custom_css_{{ snake_case($theme) }}"
                                                    placeholder="Write your css here...">{{ isset($settings['custom_css_' . snake_case($theme)]) ? $settings['custom_css_' . snake_case($theme)] : '' }}</textarea>
                                                <input type="submit" class="btn btn-primary my-3" value="{{trans('actions.save')}}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-translate" role="tabpanel"
                                aria-labelledby="v-pills-translate-tab">

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="m-0 p-0">Translations</h3>
                                    </div>
                                    <div class="card-body">
                                        <form
                                            action="{{ config('horizontcms.backend_prefix') . '/theme/update-translations/' . $theme }}"
                                            method="POST">
                                            @csrf
                                            @foreach ($translations as $lang => $value)
                                                <h3 class="m-0 p-0">{{ $lang }}</h3>
                                                <table class="table">
                                                    <thead>
                                                        <tr class="bg-dark text-white">
                                                            <th class="col-md-4">Phrase</th>
                                                            <th class="col-md-2">Language</th>
                                                            <th class="col-md-6">Translation</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($value as $a => $b)
                                                            <tr>
                                                                <td class="col-md-4"><i>{{ $a }}</i></td>
                                                                <td class="col-md-2">{{ $lang }}</td>
                                                                <td class="col-md-6"><input type='text'
                                                                        class='form-control'
                                                                        name='{{ $lang }}[{{ $a }}]'
                                                                        value="{{ $b }}"></td>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endforeach
                                            <input type="submit" class="btn btn-primary my-3" value="{{trans('actions.save')}}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    @endsection
