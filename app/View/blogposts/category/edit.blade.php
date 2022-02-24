@extends('layout')

@section('content')
<div class='container main-container'>
<h2>{{ trans('category.edit_category') }}:</h2>



<div class='col-md-12' style='margin-top:3%;'>
  <form action="{{ admin_link('blogpost_category-update',$category->id) }}" class='form-inline' role='form' method='POST'>
  

	{{ csrf_field() }}

      ID: {{ $category->id }} &nbsp
      <input type='text' class='form-control' name='name' value="{{ $category->name }}" required autofocus>

    <button type='submit' class='btn btn-default'>{{ trans('actions.save') }}</button>
  </form>

</div>

<div style='margin-top:15%;'>
    <a href="{{ admin_link('blogpost_category-index') }}" class="btn btn-info">{{ trans('actions.back') }}</a>
</div>
</br>
</br>

</div>
@endsection