@extends('layout')

@section('content')
<div class='container main-container'>
<h2 class='col-md-12'>Edit categories:</h2>



<div class='col-md-12 container' style='margin-top:3%;margin-left:15%;'>
  <form action="{{ admin_link('blogpost_category-edit',$category->id) }}" class='form-inline' role='form' method='POST'>
    <input type='hidden' class='form-control' name='id' value="{{ $category->id }}" >
      ID: {{ $category->id }} &nbsp
      <input type='text' class='form-control' name='category_name' value="{{ $category->name }}" required>

    <button type='submit' class='btn btn-default'>{{ trans('actions.save') }}</button>
  </form>

</div>

<div style='margin-top:15%;'>
    <a href="{{ admin_link('blogpost_category-index') }}" class="btn btn-info">Back to categories</a>
</div>
</br>
</br>

</div>
@endsection