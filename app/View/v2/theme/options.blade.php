@extends('layout')

@section('content')
<div class='container'>
    <h2>Theme options</h2>
    
    <div class="row pt-4">
        <div class="col-2">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Custom style</a>
            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Translations</a>
        </div>
        </div>
        <div class="col-10">
            <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <h3 class="m-0 p-0">Custom Style</h3>
                <div>
                    <form action="{{admin_link('settings-save')}}" method="POST">
                        {{csrf_field()}}
                        <textarea rows="20" style="width:100%;" class='form-control' name="custom_css_{{snake_case($theme)}}" placeholder="Write your css here...">{{ isset($settings['custom_css_'.snake_case($theme)]) ? $settings['custom_css_'.snake_case($theme)] : ""  }}</textarea>
                        <input type="submit" class="btn btn-primary my-3" value="Save">
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
            <form action="{{admin_link('').'theme/update-translations/'.$theme}}" method="POST">
                {{ csrf_field() }}
                @foreach($translations as $lang => $value)
                <h3 class="m-0 p-0">{{$lang}}</h3>
                <table class="table">
                    <thead>
                        <tr class="d-flex bg-dark text-white">
                            <th class="col-md-4">Phrase</th>
                            <th class="col-md-2">Language</th>
                            <th class="col-md-6">Translation</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($value as $a => $b)
                        <tr class="d-flex">
                            <td class="col-md-4"><i>{{$a}}</i></td>
                            <td class="col-md-2">{{$lang}}</td>
                            <td class="col-md-6"><input type='text' class='form-control' name='{{$lang}}[{{$a}}]' value="{{$b}}"></td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @endforeach
                <input type="submit" class="btn btn-primary my-3" value="Save">
            </form>
            </div>
            </div>
        </div>
    </div>

</div>
@endsection