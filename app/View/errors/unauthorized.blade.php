@extends('layout', ['title' => trans('auth.acces_denied')])

@section('content')
<div class="p-5">
    <div class="container text-center my-5">
        <h1>{{ trans('auth.acces_denied') }}!</h1>

        <p class="mt-5">{{ trans('auth.access_denied_message') }}</p>
    </div>
</div>
@endsection
