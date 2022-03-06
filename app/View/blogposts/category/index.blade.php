@extends('layout')

@section('content')
<div class='container main-container'>
<div class='row'>
<div class="col-md-12">
<h2 class='mt-2'>{{ trans('category.category') }}</h2>

<form action="{{ admin_link('blogpost_category-create') }}" class='form-inline float-right mt-4' role='form' method='POST'>

	{{ csrf_field() }}

	<div class="row g-3 align-items-center">
	<div class="col-auto">
		<label for="inputPassword6" class="col-form-label">{{ trans('category.add_category') }}:</label>
	</div>
	<div class="col-auto">
		<input type='text' class='form-control' id='cat' name='name' placeholder='Enter new category' required>
	</div>
	<div class="col-auto">
		<span class="form-text">
			<button type='submit' class='btn btn-primary'>{{ trans('actions.add') }}</button> 
		</span>
	</div>
	</div>

</form>
</div>
  
<div class='col-md-12'>

	

	
 
<table class='table table-hover mt-5'>
    <thead>
      <tr class="d-flex bg-dark text-white">
      	<th class="col-1">{{ trans('category.th_id') }}</th>
      	<!--<th>{{ trans('category.th_image') }}</th>-->
      	<th class="col">{{ trans('category.th_category') }}</th>
        <th class="col">{{ trans('category.th_posts') }}</th>
        <th class="col-5 text-center">{{trans('actions.th_action')}}</th>
      </tr>
	</thead>
	<tbody>

		@foreach($all_category as $each)
		<tr class="d-flex">
				<td class="col-1">{{ $each->id }}</td>
				<!--<td><img src='{{ $each->getThumb() }}'  class='img img-rounded' style='object-fit:cover;' width="70" height="50" /> </td>
				-->
				<td class='col'><a href="{{ admin_link('blogpost_category-view',$each->id) }}">{{ $each->name }}</a></td>     

				<td class="col">
					<span class='badge rounded-pill bg-dark'>{{ $each->blogposts->count() }}</span>
				</td>

				<td class="col-5  text-center">
					<div class='btn-group col-3' role='group'>
						<a href="{{ admin_link('blogpost_category-edit',$each->id) }}" type='button' class='btn btn-warning btn-sm'>{{trans('actions.edit')}}</a>
						<a href="{{ admin_link('blogpost_category-delete',$each->id) }}" type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
					</div>
				</td>
		</tr>
		@endforeach

	</tbody>
  </table>

</div>
</div>
</div>
@endsection