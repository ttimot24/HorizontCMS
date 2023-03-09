@extends('layout')

@section('content')
    <div class='jumbotron'>
        <div class='container'>
            <h1><small>Installing {{ config('app.name') }}</small></h1>

            <div class='progress'>
                <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='0' aria-valuemin='0'
                    aria-valuemax='100' style='min-width: 2em;'> 0% </div>
            </div>

            <hr />

            <h2>Step 1: Language</h2>

            <form action="{{ url('admin/install/step2') }}" role="form" method="POST">
                {{ csrf_field() }}

                <div class='form-group'>
                    <label for='sel1'>Select language:</label>
                    <select class='form-select' id='sel1' name='lang'>
                        @foreach ($languages as $language)
                            <option value='{{ strtolower($language) }}'>{{ $language }}</option>
                        @endforeach
                    </select>
                </div>
                </br></br>
                <a href='admin/install' class='btn btn-secondary btn-sm'><i class="fa fa-arrow-circle-o-left"
                        aria-hidden="true"></i> Previous</a>
                <button type='submit' class='btn btn-primary btn-md px-3'>Next <i class="fa fa-arrow-circle-o-right ml-2"
                        aria-hidden="true"></i></button>
            </form>


        </div>
    </div>
@endsection
