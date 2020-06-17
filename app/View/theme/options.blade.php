@extends('layout')

@section('content')
<div class='container'>
    <h1>Theme options</h1>
    <br><br>
    
    <div class='panel panel-default col-md-2' style='padding:0px;padding-top: 10px;'>
    <h4 class="container">Options</h4>
    <ul class="list-group">
        <a href="{{config('horizontcms.backend_prefix')}}/theme/options/{{$theme}}?option=style"><li class="list-group-item">Custom Style</li></a>
        <a href="{{config('horizontcms.backend_prefix')}}/theme/options/{{$theme}}?option=translate"><li class="list-group-item">Translations</li></a>
    </ul>
    </div>
    <div class="col-md-10 well">

    @if($option==='translate')
    @foreach($translations as $lang => $value)
    <h3>{{$lang}}</h3>
    <table class="table">
        <thead>
            <th>Phrase</th>
            <th>Language</th>
            <th>Translation</th>
        </thead>
        <tbody>
        @foreach($value as $a => $b)
            <tr>
                <td class="col-md-4"><i>{{$a}}</i></td>
                <td class="col-md-2">{{$lang}}</td>
                <td class="col-md-6"><input type='text' class='form-control' name='{{$a}}' value="{{$b}}"></td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endforeach
    @elseif($option==='style')
        <h3>Custom Style</h3>
        <div>
        <form action="{{admin_link('settings-save')}}" method="POST">
            {{csrf_field()}}
            <textarea rows="20" style="width:100%;" class='form-control' name="custom_css_{{snake_case($theme)}}" placeholder="Write your css here...">{{ isset($settings['custom_css_'.snake_case($theme)]) ? $settings['custom_css_'.snake_case($theme)] : ""  }}</textarea>
            <input type="submit" class="btn btn-primary" value="Save">
        </form>
        </div>
    @endif

    </div>

</div>
@endsection